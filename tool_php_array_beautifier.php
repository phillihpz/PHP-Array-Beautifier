<?php
/*
Template Name: Tool - PHP Array Beautifier

    Author:         Phillihp Harmon
    Date:           2012.01.04
    Contributor(s):     
    
    Description:    Copy a print_r() or var_dump() string into the beautifier and clean it up, indent,
                    and add color codings for easy readability.
*/
?>

<?php

class Debug {
    var $indent_size;
    var $colors = array(
        "Teal",
        "YellowGreen",
        "Tomato",
        "Navy",
        "MidnightBlue",
        "FireBrick",
        "DarkGreen"
        );
    
    function __construct() {
        $this->indent_size = '20';
    }
    
    /*
    *   Author: Phil Harmon
    *   Description:
    *       Take an array and format it to style in HTML
    *   
    *   Tasks:
    *       - Add automated color formatting                    
    */    
    function array_to_html($val) {
        $do_nothing = true;
        
        // Get string structure
        if(is_array($val)) {
            ob_start();
            print_r($val);
            $val = ob_get_contents();
            ob_end_clean();
        }
        
        // Color counter
        $current = 0;
        
        // Split the string into character array
        $array = preg_split('//', $val, -1, PREG_SPLIT_NO_EMPTY);
        foreach($array as $char) {
            if($char == "[")
                if(!$do_nothing)
                    echo "</div>";
                else $do_nothing = false;
            if($char == "[")
                echo "<div>";
            if($char == ")") {
                echo "</div></div>";
                $current--;
            }
            
            echo $char;
            
            if($char == "(") {
                echo "<div class='indent' style='padding-left: {$this->indent_size}px; color: ".($this->colors[$current % count($this->colors)]).";'>";
                $do_nothing = true;
                $current++;
            }
        }
    }
}

$postdata = g('to_convert');
get_header();
?>

<div id="container" class="one-column">
	<div id="content" role="main">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div>This simple tool takes an array or object output in PHP, such as a print_r() statement and formats it in color coding to easily read your data.</div><br />
<?php if($postdata): ?>
<div><a href="http://phillihp.com/toolz/php-array-beautifier/">Go back</a></div>
<div style="width: 940px; overflow: auto;">
<?php
    $d = new Debug();
    $d->array_to_html($postdata);
?>
</div>
<?php endif; ?>

<form action="http://phillihp.com/toolz/php-array-beautifier/" method="POST">
    <div>Code to Transform:</div>
    <div><textarea id='to_conv' name='to_convert' rows='14' cols='120'><?php echo $postdata; ?></textarea></div>
    <div><input type='submit' value='Beautify' /> <span onClick="document.getElementById('to_conv').value = 'Array([mode] => sets[sets] => Array([0] => 123[1] => 456[2] => 789)[etc] => Array([letters] => Array([0] => a[1] => b)[0] => pie[1] => sharks))';" style="color: blue; cursor: pointer;">Example</a></div>
</form>

<?php comments_template( '', true ); ?>
	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>