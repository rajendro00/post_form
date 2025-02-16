<?php 

/**
 * Plugin Name: Post Form
 * Plugin URI: https://akash.com
 * Description: This is a professional basement plugin
 * Version: 1.0.0
 * Author: Akash
 * Author URI: https://akash.com
 * License: GPL2
 * Text Domain: post-form
 */

 class post_form{
    public function __construct(){
        add_shortcode( 'post_form_shortcode', [$this,  'post_form_shortcode']);
        add_action( 'init', [$this,  'post_create'] );
    }
    public function post_form_shortcode(){
        ob_start(); ?>
      <h1>post Form</h1>
      <form action="" method="post">
        <label for="">Post Title</label>
        <input type="text" name="title"><br>
        <label for="">Post Content</label>
        <textarea name="content" id=""></textarea><br>
        <label for="">Post Category</label>
        <select name="post_cate" id="">
            <?php  
            $terms = get_terms( array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
            ) );
            // echo '<pre>';
            // print_r( $terms);
            // echo '</pre>';
            foreach($terms as $cat){ ?>
            <option value="<?php echo esc_attr($cat->term_id) ?>"><?php  echo esc_html($cat->name) ?>  </option>
           <?php }
            ?>  
        </select><br>
        <label for="">Post Status</label>
        <select name="post_status" id="">
            <?php  
            $post_statuses = get_post_statuses();
            echo '<pre>';
            print_r($post_statuses);
            echo '</pre>';
            
            foreach($post_statuses as $index=> $status){ ?>
                <option value="<?php echo esc_attr($index) ?>"><?php  echo esc_html($status) ?>  </option>
               <?php }
            
            ?>  
        </select>
        <br>
        <input type="submit" name="post_create">
      </form>
    <?php 
        return ob_get_clean();
    }
    
    public function post_create(){

        if(isset($_POST['post_create'])){
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $category = isset($_POST['post_cate']) ? $_POST['post_cate'] : '';
            $pot_status = isset($_POST['post_status']) ? $_POST['post_status'] : '';
            // echo '<pre>';
            // print_r($category);
            // echo '</pre>';
            

        $args = [
            'post_type' => 'post',
            'post_title' =>  $title,
            'post_content' =>  $content,
            'post_status' =>  $pot_status,
            'post_category' => [$category]
        ];
        $post_id = wp_insert_post($args);
        if(is_wp_error($post_id)){
            echo 'Error'. $post_id->get_error_message();
        }else{
            echo "Post Create Successfully!";
        }
    }
    }


 }
 new post_form();