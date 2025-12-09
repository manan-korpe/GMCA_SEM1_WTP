let inputTable = document.getElementById("user-input-table");
let inputField = document.getElementById("user-input");

function updateDisplay() {
    inputField.value = currentInput;
}
let currentInput = "0";

function calculate() {
    try {
        const expression = currentInput.replace(/%/g, "/100");
        currentInput = eval(expression).toString();
    } catch {
        currentInput = "Error";
    }
    updateDisplay();
}

inputTable.addEventListener("click", (e) => {
    const value = e.target.innerText;
    handleInput(value);
});

function handleInput(value) {
    const operators = ["+", "-", "*", "/", "%"];

    if (value === "CI" || value === "C") {
        currentInput = "0";
    }

    else if (value === "=") {
        calculate();
        return;
    }

    else if (value === "+/-") {
        if (currentInput.startsWith("-")) {
            currentInput = currentInput.slice(1);
        } else {
            currentInput = "-" + currentInput;
        }
    }

    else if (value === "()") {
        if (currentInput.includes("(") && !currentInput.includes(")")) {
            currentInput += ")";
        } else {
            currentInput += "(";
        }
    }

    else if (operators.includes(value)) {
        let last = currentInput.slice(-1);

        // Prevent double operator
        if (operators.includes(last)) return;

        currentInput += value;
    }

    else {
        if (currentInput === "0" || currentInput === "Error") {
            currentInput = value;
        } else {
            currentInput += value;
        }
    }

    updateDisplay();
}

document.addEventListener("keydown", (event) => {
    const key = event.key;
    const validKeys = ["+", "-", "*", "/", "%", ".", "(", ")"];

    if (!isNaN(key) || validKeys.includes(key)) {
        handleInput(key);
    }

    else if (key === "Enter" || key === "=") {
        handleInput("=");
    }

    else if (key === "Backspace") {
        currentInput =
            currentInput.length > 1 ? currentInput.slice(0, -1) : "0";
        updateDisplay();
    }

    else if (key.toLowerCase() === "c") {
        handleInput("C");
    }
});

updateDisplay();
