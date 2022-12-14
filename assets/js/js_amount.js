var amount = document.getElementById("amount"); 

    amount.addEventListener("keyup", function(e) { 
        amount.value = convertRupiah(this.value); 
    }); 

    amount.addEventListener('keydown', function(event) { 
        return isNumberKey(event); 
    }); 
