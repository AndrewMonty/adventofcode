const fs = require('fs');
const readline = require('readline');

const stream = fs.createReadStream('./input.txt');

const rl = readline.createInterface({
    input: stream,
    crlfDelay: Infinity
});

let calibrationValues = [];

let calibrationTotal = 0;

let numberMap = {
    'one': 1,
    'two': 2,
    'three': 3,
    'four': 4,
    'five': 5,
    'six': 6,
    'seven': 7,
    'eight': 8,
    'nine': 9
};

rl.on('line', (line) => {
    let numbers = [];

    for (i = 0; i < line.length; i++) {
        if (!isNaN(line[i])) {
            numbers.push(line[i]);
        }

        Object.keys(numberMap).forEach(function (key) {
            if (line.substring(i).indexOf(key) == 0) {
                numbers.push(numberMap[key].toString());
            }
        });
    }

    let value = numbers[0] + numbers[numbers.length - 1];
    calibrationValues.push(value);
    calibrationTotal += parseInt(value);
});

rl.on('close', () => {
    console.log(calibrationTotal);
});

