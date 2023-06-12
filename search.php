<!DOCTYPE html>
<html>
<head>
    <title>Live Search</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container" style="width: 40%;">
        <div class="text-center mt-5 mb-4">
            <h2>Sentiment Prediction<h2>
        </div>
        <textarea onkeyup="countWords(this);" type="text" font-size:100% class="form-control" id="live_search" autocomplete="off" placeholder="enter chords after nextline...." ></textarea>
       
        <span id="words-counter"></span>
        <script >
            function countWords(self) {
            var newline = self.value.match(/\n./g);
            var words = newline ? newline.length : 0;
 
            document.getElementById("words-counter").innerHTML = words + " chord progression";
            }
        </script>
    </div>

    <div id="searchresult"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function(){

            $("#live_search").keyup(function(){

                var input= $(this).val();
                //alert(input);

                if(input != ""){
                    $.ajax({

                        url:"query.php",
                        method:"POST",
                        data:{input:input},

                        success:function(data){
                            $("#searchresult").html(data);
                            $("#searchresult").css("display","block");
                        }
                    });
                }else{
                    $("#searchresult").css("display","none");
                }
            });
        });
    </script>
</body>
</html>