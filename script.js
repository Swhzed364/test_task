
function hideRowAndUpdateDB (rowNumber) {

  let selector = '#row' + rowNumber;

  hideRow(selector)
  updateDataBase(rowNumber)
};

function updateDataBase (rowNumber) {

  $(document).ready(function() {

    $.ajax({
      url: 'index.php',
      method: 'post',
      data: 'rowToHide=' + rowNumber,
      success: function(data){
        //alert(data);
      },
      error: function () {
        alert('db not updated')
      }});
  })
  
}

function hideRow (selector) {

  $(document).ready(function() {

    $.ajax({
      url: 'index.php',
      success: 
      $(selector).hide()
    })
  })
}


function increaseQuantity (rowNumber) {
  
  let quantity = $('#PRODUCT_QUANTITY' + rowNumber).text()

  let result = {
    'quantity' : parseInt(quantity) + 1,
    'rowNumber' : rowNumber,
  }
  setQuantity(result)
}

function decreaseQuantity (rowNumber) {

  let quantity = $('#PRODUCT_QUANTITY' + rowNumber).text()

  let result = {
    'quantity' : parseInt(quantity) - 1,
    'rowNumber' : rowNumber,
  }
  setQuantity(result)
}

function setQuantity (quantityAndRowNumber) {

  let quantity = quantityAndRowNumber['quantity']
  let rowNumber = quantityAndRowNumber['rowNumber']

  $(document).ready(function() {
    $.ajax({
      url: 'index.php',
      method: 'post',
      data: 'newQuantity=' + quantity + '&ProductID=' + rowNumber,
      success: function(data){
        //alert(data)
        $('#PRODUCT_QUANTITY' + rowNumber).text(quantity)
      },
      error: function () {
        alert('quantity not set')
    }});
  })
}
