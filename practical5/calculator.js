let inputTable = document.getElementById("user-input-table");
let inputField = document.getElementById("user-input");

function calculateExpression(expression) {
  try {
    return eval(expression);
  } catch (error) {
    return "Error";
  }
}

inputTable.addEventListener("click", (e) => {
  const clickedValue = e.target.innerText;

  if (!clickedValue || !inputField) return;

  const lastChar = inputField.value.slice(-1);
  const isOperator = /[+\-*/%]/;

  switch (clickedValue) {
    case "CI":
      inputField.value = "";
      break;

    case "+/-":
      toggleSign();
      break;

    case "=":
      if (isOperator.test(lastChar)) return;
      inputField.value = calculateExpression(inputField.value);
      break;

    default:
      if (isOperator.test(clickedValue) && isOperator.test(lastChar)) return;
      inputField.value += clickedValue;
      break;
  }
});

function toggleSign() {
  let expr = inputField.value;
  if (!expr) return;

  const lastOpIndex = Math.max(
    expr.lastIndexOf("+"),
    expr.lastIndexOf("-"),
    expr.lastIndexOf("*"),
    expr.lastIndexOf("/"),
    expr.lastIndexOf("%")
  );

  const numberPart = expr.slice(lastOpIndex + 1);
  const prefix = expr.slice(0, lastOpIndex + 1);

  if (numberPart.startsWith("(-") && numberPart.endsWith(")")) {
    inputField.value = prefix + numberPart.slice(2, -1);
  } else {
    inputField.value = prefix + "(-" + numberPart + ")";
  }
}
