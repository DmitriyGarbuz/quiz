const url = "https://docs.google.com/spreadsheets/d/140uIkrEoV9SC-ZSQChr-Xin5E_hLcWUVMv-vVA1TqNw/Sheet1/edit#gid=0";
const data = { username: "example" };



const { google } = require('googleapis');

const creds = require('./credentials.json');

// ID of the Google Sheets spreadsheet to retrieve data from
const spreadsheetId = '### spreadsheet id ###';

// Name of the sheet tab
const sheetName = 'Sheet1';

const authClient = new google.auth.JWT(
    creds.client_email,
    null,
    creds.private_key,
    ['https://www.googleapis.com/auth/spreadsheets.readonly']);

const sheets = google.sheets({ version: 'v4', auth: authClient });

sheets.spreadsheets.values.batchGet({
    spreadsheetId: spreadsheetId,
    // A1 notation of the values to retrieve  
    ranges: [sheetName + '!A:Z'],
    majorDimension: 'ROWS'
})
    .then((resp) => {
        const rangesOfValues = resp.data.valueRanges;
        rangesOfValues.forEach((range) => {
            console.log(range);
        });
    })
    .catch((err) => {
        console.log(err);
    });
