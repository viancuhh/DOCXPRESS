var certPrice = [];
certPrice['Birth Certificate'];
certPrice['Death Certificate'];
certPrice['Marriage Certificate'];
certPrice['CENOMAR'];

function getCertPrice() {
    var certificatePrice = 0;
    var theForm = document.forms["#"];
    var selectedCert = theForm.elements["certType"];
    certificatePrice = certprice[selectedCert.value];
    return certificatePrice;
}

function getQuantity() {
    var theForm = document.forms["#"];
    var quantity = theForm.elements["copies"];
    var howmany = 0;
  
    if (quantity.value !== "") {
      howmany = parseInt(quantity.value);
    }
    return howmany;
}

function getTotal() {
    var totalPrice = (getCertPrice * getQuantity());
    var total = document.getElementById('totalPrice');
  
    document.getElementById('totalPrice').innerHTML = "Total Price is $" + totalPrice;
    total.style.display = 'block';
}
