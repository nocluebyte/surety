$.validator.addMethod("AlphabetsV1", function(value, element) {
    return this.optional(element) || /^[A-Za-z\s]+$/i.test(value);
}, "The field must only contain Alphabets.");

$.validator.addMethod("AlphabetsV2", function(value, element) {
    return this.optional(element) || /^[A-Za-z,.\&\-\/\s]+$/i.test(value);
}, "The field must only contain letters, commas, hyphens, slashes, periods, ampersands, and spaces.");

$.validator.addMethod("AlphabetsV3", function(value, element) {
    return this.optional(element) || /^[A-Za-z-\/\s]+$/i.test(value);
}, "The field must only contain letters, hyphens, slashes, and spaces.");

$.validator.addMethod("AlphabetsV4", function(value, element) {
    return this.optional(element) || /^[^0-9,.?<>';:/\]*\-\/[+=!%^&()~`'"{|}@#_/ ]+$/i.test(value);
}, "The field must only contain Alphabets and Special Character");

$.validator.addMethod("AlphabetsV5", function(value, element) {
    return this.optional(element) || /^[A-Za-z\/\s]+$/i.test(value);
}, "The field must only contain letters and slashes.");

$.validator.addMethod("Numbers", function(value, element) {
    return this.optional(element) || /^[0-9]+$/i.test(value);
}, "The field must only contain Positive and Non-decimal Numbers.");

$.validator.addMethod("AlphabetsAndNumbersV1", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9\s]+$/i.test(value);
}, "The field must only contain Alphabets and Numbers.");

$.validator.addMethod("AlphabetsAndNumbersV2", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9-\/\s]+$/i.test(value);
}, "The field must only contain letters, numbers, hyphens, slashes, and spaces.");

$.validator.addMethod("AlphabetsAndNumbersV3", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9,.\&\(\)\-\/\s]+$/i.test(value);
},
"The field must only contain letters, numbers, brackets(), commas (,), hyphens (-), slashes (/), periods (.), ampersands (&), and spaces.");

$.validator.addMethod("Remarks", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9\-\/&\.\_\,\%\s*\#\"\'\’\“\‘\(\)\:\;\$\₹\[\]]+$/i.test(value);
},
"The field allowed only Alphabets, Numbers, Commas (','), Hyphens ('-'), Dot ('.'), Ampersands ('&'), Slashes ('/'), Percentage ('%'), brackets ( ) and [ ], semicolon, dollar, rupee, Underscore (_) Hash ('#'), Single-Double Quotes, Asterisk, Apostrophe(’) and Colon (':') and Space.");

$.validator.addMethod("PinCode", function(value, element) {
    return this.optional(element) || /^\d{6}$/i.test(value);
}, "The field must be a valid 6-digit PIN code.");

$.validator.addMethod("MobileNo", function(value, element) {
    return this.optional(element) || /^[0-9]{10}$/i.test(value);
}, "The field must be a valid Mobile No. eg.(7778888999)");

$.validator.addMethod("GstNo", function(value, element) {
    return this.optional(element) ||
    /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z1-9]{1}[A-Z]{1}[0-9A-Z]{1}$/.test(
    value);
}, "The field must be a valid GSTIN number (e.g., 27ABCDE1234F1Z5).");

$.validator.addMethod("PanNo", function(value, element) {
    return this.optional(element) || /(^([A-Z]{5})([0-9]{4})([A-Z]{1})$)/.test(value);
}, "The field must be a valid PAN number. (eg., ABCDE6789S)");

$.validator.addMethod("Percentage", function(value, element) {
    return this.optional(element) || /^(0100{1,1}\.?((?<=\.)0)?%?$)|(^0\d{0,2}\.?((?<=\.)\d)?%?)$/.test(value);
}, "The field must be a value between [0-100]");

$.validator.addMethod("filesize", function(value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0} MB');
function daysCalculate(date1, date2) {
    var oneDay = 1000 * 60 * 60 * 24;
    const difference = Math.abs(new Date(date1) - new Date(date2));
    return Math.round(difference / oneDay) + 1;
}

$.validator.addMethod('decimal', function(value, element) {
  return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
}, "Please enter a correct number, format 0.00");

$.validator.addMethod("AlphabetsAndNumbersV4", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9,.\&\-\/\s|-]+$/i.test(value);
},"The field must only contain letters, numbers, commas, hyphens, slashes, periods, ampersands, and spaces.");

$.validator.addMethod("AlphabetsAndNumbersV5", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9-\/\s_]+$/i.test(value);
}, "The field must only contain letters, numbers, hyphens, slashes, underscores, and spaces.");

$.validator.addMethod("AlphabetsAndNumbersV6", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9]+$/i.test(value);
}, "The field must only contain Alphabets and Numbers without spaces.");

$.validator.addMethod("AlphabetsAndNumbersV7", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9\s+-]+$/i.test(value);
}, "The field must only contain Alphabets and Numbers, hyphens, spaces and (+).");

$.validator.addMethod("LandLine", function(value, element) {
    return this.optional(element) || /^(?:\d){1,15}[+]{0,1}[-]{0,1}$/i.test(value);
}, "The field must be a valid LandLine No. [max(15), + and - are allowed.] ");

$.validator.addMethod("PercentageV1", function(value, element) {
    return this.optional(element) || /^((100(\.0{1,2})?)|([1-9]?[0-9](\.\d{1,2})?))$/i.test(value);
}, "The field must only contain Positive [0-100] Numbers and 2 decimal point value.");

$.validator.addMethod("DecimalV2", function(value, element) {
    return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1}))))$/i.test(value);
}, "The field must only contain Positive numbers and 1 Decimal point value.");

$.validator.addMethod("AlphabetsAndNumbersV8", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9\/\,\.\&\$\@\-\(\)\s]+$/i.test(value);
}, "The field must only contain Letters, Numbers, commas, spaces, hyphens, @, $, ampersands(&), brackets(), periods and slashes.");

$.validator.addMethod("AlphabetsAndNumbersV9", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9\/\.\-\(\)\s]+$/i.test(value);
}, "The field must only contain Letters, Numbers, spaces, hyphens, brackets(), periods and slashes.");

$.validator.addMethod("PinCodeV2", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9\s]{0,15}$/i.test(value);
}, "The field must only contain Letters, Numbers and spaces (max-length 15).");