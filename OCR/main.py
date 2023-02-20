from textractor import Textractor
from textractor.data.constants import TextractFeatures
import csv
import boto3
import pathlib
import os
boto3.setup_default_session(profile_name='ocruser')
s3 = boto3.resource('s3')
import json
import pandas as pd
import pprint

def obj_last_modified(myobj):
    return myobj.last_modified

ocr_bucket = s3.Bucket('reconwear-ocr')
unsorted = []
for file in ocr_bucket.objects.filter(Delimiter='/', Prefix='inbound/'):
    copy_source = { 'Bucket': 'reconwear-ocr', 'Key': file.key }
    file_extension = pathlib.Path(file.key).suffix
    if (file_extension.startswith(".tif")):
        unsorted.append(file)
    else:
        filename=os.path.basename(file.key)
        if (filename!=""):
            ocr_bucket.copy(copy_source, 'archive/'+filename)
            s3.Object('reconwear-ocr', file.key).delete()
files_to_ocr = [obj.key for obj in sorted(unsorted, key=obj_last_modified, reverse=False)][0:9]
print(files_to_ocr)

extractor = Textractor(profile_name="ocruser")

for file in files_to_ocr:
    file_to_ocr='s3://reconwear-ocr/'+file
    client = boto3.client('textract')
    response2 = client.analyze_document(
        Document={'S3Object': {'Bucket': 'reconwear-ocr', 'Name': file}},
        FeatureTypes=["TABLES", "FORMS"]
    )
    document = extractor.analyze_document(
        file_source=file_to_ocr,
        features=[TextractFeatures.FORMS, TextractFeatures.TABLES]
    )

# imageFileName="/Users/admin/Documents/ArmyTee/Forms/JACKSON_PERFORMANCE_FORM/SAMPLE 2/PNG/PERFORMACE_SAMPLE_2_FRONT_300.png";

# imageFileName="/Users/admin/Documents/ArmyTee/Forms/JACKSON_PERFORMANCE_FORM/SAMPLE 2/PNG/PERFORMACE_SAMPLE_2_BACK_300.png";

# imageFileName="/Users/admin/Documents/ArmyTee/Forms/JACKSON_ELITE_FORM/SAMPLE 2/PNG/ELITE_SAMPLE_2_FRONT_300.png";
# imageFileName="/Users/admin/Documents/ArmyTee/Forms/JACKSON_ELITE_FORM/SAMPLE 2/PNG/ELITE_SAMPLE_2_BACK_300.png";

# imageFileName="/Users/admin/Documents/ArmyTee/Forms/JACKSON_SOLDIER_CARD/SAMPLE 1/PNG/SOLDIER CARD_SAMPLE_1_600.png";
imageFileName="/Users/admin/Documents/ArmyTee/Forms/JACKSON_SOLDIER_CARD/SAMPLE 2/PNG/SOLDIER CARD_SAMPLE_2_600.png";

# document = extractor.analyze_document(file_source=imageFileName,features=[TextractFeatures.FORMS])

# document = extractor.detect_document_text(imageFileName)
document = extractor.analyze_document(
    file_source=imageFileName,
    features=[TextractFeatures.FORMS, TextractFeatures.TABLES]
)

def readTableCell(table, col_index):
    class output:
        pass
    output.value=table.table_cells[col_index].text.strip().replace("+$3.00", "");
    if output.value=="I" or output.value=="l" or output.value=="i":
        output.value="1"
    output.confidence=table.table_cells[col_index].confidence;
    return output;


def soldier_card_processing(filename, formdoc):
    with open("soldier_card_output.csv", 'w', newline='') as file:
        writer = csv.writer(file)
        writer.writerow(["Field", "Value", "Confidence"])
        for index, itemdata in enumerate(formdoc.key_values):
            val = format(itemdata.value)
            # if format(itemdata.key) == 'Battalion':
            # val = "'" + val
            writer.writerow([itemdata.key, format(val), itemdata.confidence])
        for index, chkboxes in enumerate(formdoc.checkboxes):
            writer.writerow([chkboxes.key, format(chkboxes.value), itemdata.confidence])
    print(filename + " written")

def performance_card_processing(filename, formdoc):
    with open("performance_card_output.csv", 'w', newline='') as file:
        writer = csv.writer(file)
        writer.writerow(["Field", "Value", "Confidence"])
        for index, itemdata in enumerate(formdoc.key_values):
            val = format(itemdata.value)
            keyname = format(itemdata.key)
            if "OFFICE USE ONLY" not in keyname:
                # if format(itemdata.key) == 'Battalion':
                # val = "'" + val
                writer.writerow([keyname, format(val), itemdata.confidence])
        platoonArtGearTable=formdoc.tables[0];
        headGearTable=formdoc.tables[1];
        data_output = {};
        data_output["P1_SM_QTY"]=readTableCell(platoonArtGearTable, 14);
        data_output["P1_MED_QTY"]=readTableCell(platoonArtGearTable, 15);
        data_output["P1_LRG_QTY"]=readTableCell(platoonArtGearTable, 16);
        data_output["P1_XL_QTY"]=readTableCell(platoonArtGearTable, 17);
        data_output["P1_XXL_QTY"]=readTableCell(platoonArtGearTable, 18);
        data_output["P2_SM_QTY"]=readTableCell(platoonArtGearTable, 24);
        data_output["P2_MED_QTY"]=readTableCell(platoonArtGearTable, 25);
        data_output["P2_LRG_QTY"]=readTableCell(platoonArtGearTable, 26);
        data_output["P2_XL_QTY"]=readTableCell(platoonArtGearTable, 27);
        data_output["P2_XXL_QTY"]=readTableCell(platoonArtGearTable, 28);
        data_output["P3_SM_QTY"]=readTableCell(platoonArtGearTable, 34);
        data_output["P3_MED_QTY"]=readTableCell(platoonArtGearTable, 35);
        data_output["P3_LRG_QTY"]=readTableCell(platoonArtGearTable, 36);
        data_output["P3_XL_QTY"]=readTableCell(platoonArtGearTable, 37);
        data_output["P3_XXL_QTY"]=readTableCell(platoonArtGearTable, 38);
        data_output["H1_QTY"]=readTableCell(headGearTable, 11);
        data_output["H2_QTY"]=readTableCell(headGearTable, 18);
        data_output["H3_QTY"]=readTableCell(headGearTable, 25);
        data_output["H4_QTY"]=readTableCell(headGearTable, 32);

        for index, key in enumerate(data_output):
            itemdata = data_output[key]
            val = format(itemdata.value)
            writer.writerow([key, format(val), itemdata.confidence])
    print(filename + " written")

def elite_card_processing(filename):
  print(filename + " Refsnes")

if "SOLDIER INFORMATION" in document.text:
    soldier_card_processing(imageFileName, document);
if "PREMIUM APPAREL & GEAR MADE FOR SOLDIERS" in document.text:
    performance_card_processing(imageFileName, document);

