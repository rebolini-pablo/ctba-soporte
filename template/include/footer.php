    <script data-main="<?php echo Helper::asset('js/Main'); ?>" src="<?php echo Helper::asset('js/require.js'); ?>"></script>
    <script>
  		require.config({
  		    urlArgs: "bust=" + (new Date()).getTime()
  		});
    </script>
  </body>
</html>