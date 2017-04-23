<script>
    function countdown (i) {
      if (i == undefined) {
        i = 10;
      }
      console.log(i);
      if (i > 0) {
        i--;
        var timeout = window.setTimeout('countdown(' + i + ')', 1000);
      }
    }
    countdown();
</script>
