
<script src="js/lib/jquery/jquery.min.js"></script>

<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>

<script src="js/jquery.slimscroll.js"></script>

<script src="js/sidebarmenu.js"></script>

<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="js/lib/datamap/d3.min.js"></script>
<script src="js/lib/datamap/topojson.js"></script>
<script src="js/lib/datamap/datamaps.world.min.js"></script>
<script src="js/lib/datamap/datamap-init.js"></script>
<script src="js/lib/weather/jquery.simpleWeather.min.js"></script>
<script src="js/lib/weather/weather-init.js"></script>
<script src="js/lib/owl-carousel/owl.carousel.min.js"></script>
<script src="js/lib/owl-carousel/owl.carousel-init.js"></script>

<script src="js/lib/echart/echarts.js"></script>
<script src="js/lib/echart/dashboard1-init.js"></script>


      <script src="js/custom.min.js"></script>
      <script src="js/lib/datatables/datatables.min.js"></script>
      <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
      <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
      <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
      <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
      <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
      <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
      <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
      <script src="js/lib/datatables/datatables-init.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js" integrity="sha512-uE2UhqPZkcKyOjeXjPCmYsW9Sudy5Vbv0XwAVnKBamQeasAVAmH6HR9j5Qpy6Itk1cxk+ypFRPeAZwNnEwNuzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.js" integrity="sha512-x+43Y+MDvh0dRFclgltcK6CpxRjxefGVpVO97BMN0g2JATq9kM3L18Yg/lmmBck7wWlhf+PKi0FAg1iZGmiUmg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.js" integrity="sha512-cG69LpvCJkui4+Uuj8gn/zRki74/E7FicYEXBnplyb/f+bbZCNZRHxHa5qwci1dhAFdK2r5T4dUynsztHnOS5g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  
    <script>
         function StatusA(id,column,value,table,status){
            // alert(id);
                      swal({
         		title: "Are you sure?",
         		text: "You want to "+status+" this section.",
         		icon: "warning",
         		buttons: true,
         		dangerMode: true,
         		})
         		.then((willDelete) => {
         		if (willDelete) {
         		 $.ajax({
                           url: "code/ManageStatus.php?flag=Delete",
                           type: "post",
                           data: {"id": id,"column":column,"value":value,"table":table,"status":status },
                           success: function(r) {
                               if(r=='Success'){
                                   swal(""+status+"", "Selected data has been "+status+".", "success");
                                   window.setTimeout(function() {
                                 window.location.reload();
                             }, 800);
                               }
                               else{
                                    swal("Failed"," Try  ! Again", "error");
                               }
                           }
                       })
         		}
         		});
                  }
				  
				 
      </script>
      <script>

$.fn.dataTable.ext.errMode = 'none';
      </script>
      