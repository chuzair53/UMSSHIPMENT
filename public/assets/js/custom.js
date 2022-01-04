
  $(document).ready(function () {
  
      var listItems = document.querySelectorAll("tr");
    
      listItems.forEach(function(item) {
        item.onclick = function(e) {
          // For tracking number
          var track_id = $(this).closest("tr").find('td:eq(1)').text();
        
           $('#statusSelect').html(e.target.innerText);
           $("#trackingNumber").attr("value", track_id);
          
        }
       
      });

});



$(document).ready(function () {
  
  var listItems = document.querySelectorAll("tr");

  listItems.forEach(function(item) {
    item.onclick = function(e) {
      // For tracking number
      var track_id = $(this).closest("tr").find('td:eq(1)').text();
    console.log(track_id + e.target.innerText);
       $('#driverSelect').html(e.target.innerText);
       $("#shipment_id").attr("value", track_id);
      
    }
   
  });

});
