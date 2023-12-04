const fs = require('fs');
const readline = require('readline');

const stream = fs.createReadStream('./input.txt');

const rl = readline.createInterface({
    input: stream,
    crlfDelay: Infinity
});

let calibrationValues = [];
let calibrationTotal = 0;

rl.on('line', (line) => {
    let numbers = [];

    for (let char of line) {
        if (!isNaN(char)) {
            numbers.push(char);
        }
    }

    let value = numbers[0] + numbers[numbers.length - 1];
    calibrationValues.push(value);
    calibrationTotal += parseInt(value);
});

rl.on('close', () => {
    console.log(calibrationTotal);
})
