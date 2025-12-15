app.controller("calculatorController", function ($scope) {
    $scope.currentInput = "0";
    $scope.calculate = function () {
        try {
            const expression = $scope.currentInput.replace(/%/g, "/100");
            $scope.currentInput = eval(expression).toString();
        } catch {
            $scope.currentInput = "Error";
        }
    };

    $scope.handleInput = function (value) {
        const operators = ["+", "-", "*", "/", "%"];

        if (value === "CI" || value === "C") {
            $scope.currentInput = "0";
        }else if (value === "=") {
            $scope.calculate();
            return;
        }else if (value === "+/-") {
            if ($scope.currentInput.startsWith("-")) {
                $scope.currentInput = $scope.currentInput.slice(1);
            } else {
                $scope.currentInput = "-" + $scope.currentInput;
            }
        }else if (value === "()") {
            if ($scope.currentInput.includes("(") && !$scope.currentInput.includes(")")) {
                $scope.currentInput += ")";
            } else {
                $scope.currentInput += "(";
            }
        }else if (operators.includes(value)) {
            let last = $scope.currentInput.slice(-1);
            if (operators.includes(last)) return;
            $scope.currentInput += value;
        }else {
            if ($scope.currentInput === "0" || $scope.currentInput === "Error") {
                $scope.currentInput = value;
            } else {
                $scope.currentInput += value;
            }
        }
    };

    document.addEventListener("keydown", (event) => {
        const key = event.key;
        const validKeys = ["+", "-", "*", "/", "%", ".", "(", ")"];

        if (!isNaN(key) || validKeys.includes(key)) {
            $scope.$apply(() => $scope.handleInput(key));
        }else if (key === "Enter" || key === "=") {
            $scope.$apply(() => $scope.handleInput("="));
        }else if (key === "Backspace") {
            $scope.$apply(() => {
                $scope.currentInput =
                    $scope.currentInput.length > 1
                        ? $scope.currentInput.slice(0, -1)
                        : "0";
            });
        }else if (key?.toLowerCase() === "c") {
            $scope.$apply(() => $scope.handleInput("C"));
        }
    });

});
