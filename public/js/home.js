window.onload = async () => {
    let currencies;
    if (localStorage.getItem('symbols')) {
        currencies = JSON.parse(localStorage.getItem('symbols'));
    } else {
        currencies = await this.loadCurrencies();
    }
    this.addCurrencies(currencies)
}

async function loadCurrencies() {
    return fetch('http://data.fixer.io/api/symbols?access_key=24adc2ed6d61612bc2d1c678e4b3ab80')
        .then(response => response.json())
        .then(async (data) => {
            if (data.success) {
                localStorage.setItem('symbols', JSON.stringify(Object.keys(data.symbols)));
                return Object.keys(data.symbols);
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: "Couldn't load the data",
                    icon: 'error',
                })
            }
        })
        .catch(e => console.error(e))
}

function addCurrencies(options) {
    const fromCurrencySelect = document.getElementById('fromCurrency');
    const toCurrencySelect = document.getElementById('toCurrency');
    options.forEach( (opt) => {
        const optionF = document.createElement('OPTION')
        optionF.innerText = opt
        optionF.value = opt
        fromCurrencySelect.append(optionF)

        const optionT = document.createElement('OPTION')
        optionT.innerText = opt
        optionT.value = opt
        toCurrencySelect.append(optionT)
    });
}
