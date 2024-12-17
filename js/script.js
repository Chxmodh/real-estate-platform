let menu = document.querySelector('.header .nav .menu');

document.querySelector('#menu-btn').onclick = () =>{
    menu.classList.toggle('active');
}

window.onscroll = () =>{
    menu.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(inputNumber => {
    inputNumber.oninput = () =>{
        if(inputNumber.value.length > inputNumber.maxLength) inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
    };
});

document.querySelectorAll('.faq .box-container .box h3').forEach(heading =>{
    heading.onclick = () =>{
       heading.parentElement.classList.toggle('active');
    }
});




const calculateBtn = document.getElementById("calculateBtn");
const resultContainerAfford = document.getElementById("resultContainer");
const resultTextAfford = document.getElementById("resultText-1");
const convertBtn = document.getElementById("convertBtn");
const resultTextCurrency = document.getElementById("resultText-2");
const fromCurrencySelect = document.getElementById("fromCurrency");
const toCurrencySelect = document.getElementById("toCurrency");

// Fetch the currencies
async function fetchCurrencies() {
  try {
    // Fetch the list of currencies (base USD)
    const response = await fetch("https://api.exchangerate-api.com/v4/latest/USD");
    const data = await response.json();
    const currencies = Object.keys(data.rates);

    // Add the options to the dropdowns
    currencies.forEach(currency => {
      const optionFrom = document.createElement("option");
      optionFrom.value = currency;
      optionFrom.textContent = currency;
      fromCurrencySelect.appendChild(optionFrom);

      const optionTo = document.createElement("option");
      optionTo.value = currency;
      optionTo.textContent = currency;
      toCurrencySelect.appendChild(optionTo);
    });
  } catch (error) {
    console.error("Error fetching currencies:", error);
  }
}

fetchCurrencies();

// Affordability Calculator logic
calculateBtn.addEventListener("click", () => {
  const income = parseFloat(document.getElementById("income").value);
  const expenses = parseFloat(document.getElementById("expenses").value);
  const loanAmount = parseFloat(document.getElementById("loanAmount").value);

  // Check for valid input
  if (isNaN(income) || isNaN(expenses) || isNaN(loanAmount)) {
    resultTextAfford.textContent = "Please enter valid numbers in all fields.";
    resultContainerAfford.classList.remove("hidden");
    return;
  }

  const remainingIncome = income - expenses;

  if (remainingIncome >= loanAmount / 12) {
    resultTextAfford.textContent = 
    `This property can be afforded with a monthly surplus of $${remainingIncome.toFixed(2)}.`;
  } else {
    resultTextAfford.textContent = 
    `Insufficient balance, Your monthly surplus is $${remainingIncome.toFixed(2)}.`;
  }

  resultContainerAfford.classList.remove("hidden");
});

// Currency Converter logic
convertBtn.addEventListener("click", async () => {
  const amount = document.getElementById("amount").value;
  const fromCurrency = fromCurrencySelect.value;
  const toCurrency = toCurrencySelect.value;

  if (amount === "" || isNaN(amount)) {
    resultTextCurrency.textContent = "Please enter a valid amount.";
    resultTextCurrency.parentElement.classList.remove("hidden");
    return;
  }

  try {
    // Fetch exchange rates 
    const response = await fetch(`https://api.exchangerate-api.com/v4/latest/${fromCurrency}`);
    const data = await response.json();

    const rate = data.rates[toCurrency];
    if (!rate) {
      resultTextCurrency.textContent = `Conversion rate for ${toCurrency} not found.`;
    } else {
      const convertedAmount = (amount * rate).toFixed(2);
      resultTextCurrency.textContent = `${amount} ${fromCurrency} = ${convertedAmount} ${toCurrency}`;
    }
    resultTextCurrency.parentElement.classList.remove("hidden");
  } catch (error) {
    resultTextCurrency.textContent = "Error fetching exchange rates. Please try again.";
    resultTextCurrency.parentElement.classList.remove("hidden");
  }
});


