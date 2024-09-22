<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f4f8;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      text-align: center;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: black;
      margin-bottom: 20px;
    }

    a {
      display: block;
      margin: 10px 0;
      padding: 10px 15px;
      font-size: 16px;
      color: #ffffff;
      background-color: #4CAF50;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    a:hover {
      background-color: seashell;
    }
    .button-89 {
  --b: 3px; /* border thickness */
  --s: 0.45em; /* size of the corner */
  --color: #373b44;

  padding: calc(0.5em + var(--s)) calc(0.9em + var(--s));
  color: var(--color);
  --_p: var(--s);
  background: conic-gradient(
      from 90deg at var(--b) var(--b),
      #0000 90deg,
      var(--color) 0
    )
    var(--_p) var(--_p) / calc(100% - var(--b) - 2 * var(--_p))
    calc(100% - var(--b) - 2 * var(--_p));
  transition: 0.3s linear, color 0s, background-color 0s;
  outline: var(--b) solid #0000;
  outline-offset: 0.6em;
  font-size: 16px;

  border: 0;

  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-89:hover,
.button-89:focus-visible {
  --_p: 0px;
  outline-color: var(--color);
  outline-offset: 0.05em;
}

.button-89:active {
  background: var(--color);
  color: #fff;
}

  </style>
</head>
<body>
  <div class="container">
    <h1>Loan Calculators</h1>
    <a href="calculator_home.php" class="button-89">Home Loan Calculator</a>
    <a href="calculator_student.php" class="button-89">Student Loan Calculator</a>
    <a href="calculator_cc.php" class="button-89">CC Loan Calculator</a>
  </div>
</body>
</html>
