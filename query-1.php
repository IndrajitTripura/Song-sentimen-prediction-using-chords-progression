<?php
    include("sql_connect.php");
    if(isset($_POST['input'])){

        if(!empty($_POST['input']))
        {
            $query=str_replace(" ","+",$_POST['input']);
        }

        $input =explode("\n", $_POST['input']);
        

        $string_to_find = array("sus4","sus2","add","5","dim");
        $string_to_replace = array("","","","","");

        $input = str_replace($string_to_find,$string_to_replace,$input);

        


        $condition = "";

        foreach($input as $text)
        {
            $condition .= "BINARY CHORD_P = '$text' OR ";

        }
        $condition = substr($condition, 0,-4);
        $query = "SELECT * FROM `chord progression` WHERE " .$condition;
        

        $result = mysqli_query($con,$query);
        

        if(mysqli_num_rows($result) > 0){?>

            <table align=center class="table table-bordered table-striped mt-4" style="width:30%">
                
                <caption style="caption-side:top">unique Chord Progression data found</caption>
                
                <thead>
                    <tr>
                        <th>chord</th>
                        <th>sentiment</th>
                        <th>%</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                        $neg_count=0;
                        $neu_count=0;
                        $pos_count=0;
                        while($row = mysqli_fetch_assoc($result)){

                            
                            $chord = $row['CHORD_P'];
                            $sentiment = $row['SENTIMENT'];
                            $neg = $row['NEGATIVE'];
                            $neu = $row['NEUTRAL'];
                            $pos = $row['POSITIVE'];
                            $percentage=0;
                            $symbol="%";

                            if($sentiment=="Negative"){
                                $percentage = ($neg/($neg+$neu+$pos))*100;
                                $neg_count++;
                                
                                
                            }elseif($sentiment=="Neutral"){
                                $percentage = ($neu/($neg+$neu+$pos))*100;
                                $neu_count++;
                                
                            
                                
                            }else{
                                $percentage = ($pos/($neg+$neu+$pos))*100;
                                $pos_count++;
                                
                            }
                            

                            

                            

                            ?>
                            <tr>
                                <td><?php echo $chord;?></td>
                                <td><?php echo $sentiment;?></td>
                                <td><?php echo number_format($percentage,2).$symbol;?></td>
                            </tr>
                            <?php
                        }
                        

                            

                    ?>
                </tbody>
            </table>
                        


        <?php


        }else{

            echo "<h6 class='text-danger text-center mt-3'>No data Found</h6>";

        }
        ?>
            <table align=center class="table table-bordered table-striped mt-4" style="width:30%">
                
            <caption style="caption-side:top">SONG SENTIMENT OUTPUT</caption>
        
            <thead>
                <tr>
                    <th>sentiment</th>
                    <th>%</th>
                </tr>
            </thead>

        <tbody>
            <?php
                global $neg_count;
                global $neu_count;
                global $pos_count;
                
                $sum=$neg_count+$neu_count+$pos_count;
                $song_sentiment='';
                $pertge='';
                
                if($neg_count>$neu_count && $neg_count>$pos_count){
                    $song_sentiment="Negative";
                    $pertge=($neg_count/$sum)*100;
                    
                    
                }elseif($neu_count>$neg_count && $neu_count>$pos_count){
                    $song_sentiment="Neutral";
                    $pertge=($neu_count/$sum)*100;
                    
                
                    
                }else{
                    $song_sentiment="Positive";
                    $pertge=($pos_count/$sum)*100;
                    
                }

                    ?>
                    <tr>
                        <td><?php echo $song_sentiment;?></td>
                       
                        <td><?php echo number_format($pertge,2).$symbol;?></td>
                    </tr>
                    <?php
                

            ?>
        </tbody>
    </table>     
    <?php          
    }
?>