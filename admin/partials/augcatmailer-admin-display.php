<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://94.244.191.245/wordpress/
 * @since      1.0.0
 *
 * @package    Augcatmailer
 * @subpackage Augcatmailer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section class="ac-section ac-header">
    <h1 class="am_h1">AugCat50 Mailer</h1>
    <h2>Create a form, insert a shortcode into the page </h2>
</section>

<section class="ac-section am__add-sect js_am__add-sect">
    <div class="am_gray-border am_add-field">
        <h3 class="admin-blue-header">Form name:</h3>
        <p class="ac-input-p"><input type="text" class="blue-border-input js_am__form-name" placeholder="Form name"></p>
        <p class="ac-p">Form classes. Split by spaces</p>
        <p class="ac-input-p"><input type="text" class="js_am__form-class" placeholder="class1 class2"></p>
    </div>
    
    <div class="am_gray-border am_add-field">
        <h3 class="admin-blue-header">Add field</h3>
        <div>
            <select class="blue-border-input js_am_field-type">
                <option value="text">Text</option>
                <option value="email">Email</option>
                <option value="textarea">Textarea</option>
                <option value="tel">Tel</option>
                <option value="url">Url</option>
                <option value="submit">Submit button</option>
            </select>
            
            <p class="ac-p">Field classes. Split by spaces</p>
            <p class="ac-input-p"><input type="text" class="js_am_field-class" placeholder="class1 class2"></p>
            <br>
            
            <p class="ac-p">Placeholder</p>
            <p class="ac-input-p"><input type="text" class="js_am_field-placeholder" placeholder="placeholder"></p>
        </div>
        
        <div>
            <h3>Label (leave empty - no label)</h3>
            <p class="ac-input-p"><input type="text" class='js_am_field-label' placeholder='Label text'></p>
            <p class="ac-p">Label classes. Split by spaces</p>
            <p class="ac-input-p"><input type="text" class='js_am_field-label-class' placeholder='class1 class2'></p>
        </div>
        <br>
        
        <div>
            <h3>Wrapper tag (leave empty - no wrapper)</h3>
            <p class="ac-input-p"><input type="text" class='js_am_field-wrapper' placeholder='div'></p>
            <p class="ac-p">Wrapper classes. Split by spaces</p>
            <p class="ac-input-p"><input type="text" class='js_am_field-wrapper-class' name='wrapper-classes' placeholder='class1 class2'></p>
        </div>
        
        <button class="blue-border-button js_am__add-field">Add field</button>
    </div>
    
    <div class="am_gray-border am__fields-container js_am__fields-container">
        <h3 class="admin-blue-header">Fields:</h3>
        <p class='js_am_no-fields'>No fields added.</p>
        <table class='am_fields-table js_am_fields-table' hidden='true'>
            <tr>
                <th>Order</th>
                <th>Type</th>
                <th>Class</th>
                <th>Placeholder</th>
                <th>Label</th>
                <th>L class</th>
                <th>Wrapper</th>
                <th>W class</th>
            </tr>
        </table>
        <button id="qwe" class="blue-border-button js_am__save-form">Save form</button>
    </div>
</section>

<br>

<section class="ac-section am_gray-border am__list-sect js_am__list-sect">
    <h3 class="admin-blue-header">Saved Forms:</h3>
    <div class='js_am__list-sect__wrapper'>
        <?php
            $list = scandir("../wp-content/plugins/augcatmailer/storage");
            
            //Вывод списка файлов с сохранёнными формами
            foreach ($list as $file) {
                if ($file != '.' && $file != '..') {
                    $file = str_replace('.html', '', $file);
                    echo "<p class='list__form-name js_list__form-name'>$file</p>";
                }
            }
            
            //Если в массиве есть только '.', '..' - массив пуст.
            if (count($list) == 2) {
                echo '<p>No forms saved.</p>';
            }
        ?>
    </div>
    <div class='js_am__list-sect__prew'>
    </div>
</section>

<section class="ac-section am_gray-border am__system-message js_am__system-message">
</section>

<section class="ac-section am_gray-border am__note-sect">
    <h2>В планах добавить:</h2>
    <p>Возможность менять вёрстку</p>
<!--    <p>Убрать ограничение на количество полей. Добавить новые типы полей.</p>-->
<!--    <p>Возможность менять параметры полей: id, name, placeholder.</p>-->
    <p>Возможность менять конфиг PHPMailer'а из админки.</p>
<!--    <p>Возможность подключить свой js скрипт обработки формы.</p>-->
</section>
