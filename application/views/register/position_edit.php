<?php 
if($teeth_record){
    //echo "<pre>";print_r($teeth_record);exit;
    foreach($teeth_record as $row){
?>  
<div class="inputfield" id="fill">
    <table>
        <input type="hidden" class="fill_urn" name="fill_urn" value="<?=$row->urn?>">
        <!--*****************************Top Teeth*****************************-->
        <tr style="border-bottom:1px solid #000;">
            <!--*****************************Top Right Teeth*****************************-->
            <td style="border-right:1px solid #000; padding-bottom:15px;">
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>8</stron></span><br>
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright8 == 1){echo "checked='checked'";} ?> name="topr8" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>7</stron></span><br>
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright7 == 1){echo "checked='checked'";} ?> name="topr7" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>6</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright6 == 1){echo "checked='checked'";} ?> name="topr6" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>5</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright5 == 1){echo "checked='checked'";} ?> name="topr5" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>4</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright4 == 1){echo "checked='checked'";} ?> name="topr4" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>3</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright3 == 1){echo "checked='checked'";} ?> name="topr3" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>2</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright2 == 1){echo "checked='checked'";} ?> name="topr2" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows" style="margin-right:10px">
                    <span class='toplabel'><strong>1</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topright1 == 1){echo "checked='checked'";} ?> name="topr1" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
            </td>
            
            <!--*****************************Top left Teeth*****************************-->
            <td style="padding-bottom:15px;">
                <div class="checkbox-container inrows" style="margin-left:10px;">
                    <span class='toplabel'><strong>1</stron></span><br>
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft1 == 1){echo "checked='checked'";} ?> name="topl1" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>2</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft2 == 1){echo "checked='checked'";} ?> name="topl2" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>3</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft3 == 1){echo "checked='checked'";} ?> name="topl3" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>4</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft4 == 1){echo "checked='checked'";} ?> name="topl4" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>5</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft5 == 1){echo "checked='checked'";} ?> name="topl5" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>6</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft6 == 1){echo "checked='checked'";} ?> name="topl6" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>7</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft7 == 1){echo "checked='checked'";} ?> name="topl7" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>8</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="top" <?php if($row->topleft8 == 1){echo "checked='checked'";} ?> name="topl8" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows" style="margin-right:0;">
                    <span><strong><?=$this->lang->line("all");?></stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="topall" id="topall" onclick="selectAll('topall','top');" name="topall" value="all" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>   
                </div>
            </td>
        </tr>
        
        <!--*****************************Bottom Teeth*****************************-->
        <tr>
            <!--*****************************bottom Right Teeth*****************************-->
            <td style="border-right:1px solid #000;padding-top:5px;">
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>8</stron></span><br>
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright8 == 1){echo "checked='checked'";} ?> name="bottomr8" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>7</stron></span><br>
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright7 == 1){echo "checked='checked'";} ?> name="bottomr7" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>6</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright6 == 1){echo "checked='checked'";} ?> name="bottomr6" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>5</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright5 == 1){echo "checked='checked'";} ?> name="bottomr5" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>4</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright4 == 1){echo "checked='checked'";} ?> name="bottomr4" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>3</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright3 == 1){echo "checked='checked'";} ?> name="bottomr3" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>2</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright2 == 1){echo "checked='checked'";} ?> name="bottomr2" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows" style="margin-right:10px">
                    <span class='toplabel'><strong>1</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomright1 == 1){echo "checked='checked'";} ?> name="bottomr1" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
            </td>
            
            <!--*****************************Bottom Left Teeth*****************************-->
            <td style="padding-top:5px;">
                <div class="checkbox-container inrows" style="margin-left:10px;">
                    <span class='toplabel'><strong>1</stron></span><br>
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft1 == 1){echo "checked='checked'";} ?> name="bottoml1" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>2</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft2 == 1){echo "checked='checked'";} ?> name="bottoml2" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>3</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft3 == 1){echo "checked='checked'";} ?> name="bottoml3" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>4</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft4 == 1){echo "checked='checked'";} ?> name="bottoml4" value="1"> 
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>5</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft5 == 1){echo "checked='checked'";} ?> name="bottoml5" value="1" >
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>6</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft6 == 1){echo "checked='checked'";} ?> name="bottoml6" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>7</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft7 == 1){echo "checked='checked'";} ?> name="bottoml7" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows">
                    <span class='toplabel'><strong>8</stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottom" <?php if($row->bottomleft8 == 1){echo "checked='checked'";} ?> name="bottoml8" value="1">
                        <span class="checkbox-custom rectangular"></span>
                    </label>
                </div>
                <div class="checkbox-container inrows" style="margin-right:0;">
                    <span><strong><?=$this->lang->line("all");?></stron></span><br> 
                    <label class="checkbox-labels">
                        <input type="checkbox" class="bottomall" id="bottomall" onclick="selectAll('bottomall','bottom');" name="bottomlall" value="all">
                        <span class="checkbox-custom rectangular"></span>
                    </label>   
                </div>
            </td>
        </tr>
    </table>
</div>

<?php
    }
}
?>