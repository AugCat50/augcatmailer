<?php

class Augcatmailer_Save_Form
{
//    private $source = array();
    private $file;
    private $formName;
    
    
    public function __construct()
    {
    }
    
    /**
    * Публичный руководящий метод класса.
    */
    public function save(string $data) : string
    {
        $source = $this->decode($data);
        $html   = $this->html_builder($source);
        $saved  = $this->save_to_file($html);
        
        if (!$saved) {
            return "Failed to save in file.";
        } else {
            return 'Success. Written ' . $saved . ' bytes.';
        }
    }
    
    /**
    * Декодируем входящий JSON назад в массив
    */
    private function decode(string $data) : array
    {
        $data   = str_replace('\\', "", $data);
        $result = json_decode($data, true);
        
        usort($result, function($a,$b){
            if (isset($a['order']) && isset($a['order'])) {
                return ($a['order']-$b['order']);
            }
            
        });
        
        return $result;
    }
    
    /**
    * Формировка html. 
    *
    * $data[$i]['wrapper'];
    * $data[$i]['wrapper_class'];
    * $data[$i]['label'];
    * $data[$i]['label_class'];
    * $data[$i]['type'];
    * $data[$i]['class'];
    * $data[$i]['placeholder'];
    */
    private function html_builder(array $data) : string
    {
        print_r($data);
        
        $beginning = '';
        $end       = '';
        $body      = '';
        
        for($i=0; $i<count($data); $i++) {
            
            if ($i === 0) {
                
                $time      = date("Y-m-d_H-i-s");
                $beginning = '<div class="conteiner-fluit">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <form id="' . $time . '" class="' . $data[0]['formClass'] . '" role="form">
                                            <div class="ajax-hidden">';
                $end       = '</div><div class="ajax-response"></div></form></div></div></div>';
                
                if ( $data[0]['formName'] === '') {
                    $this->formName = $time;
                } else {
                    $this->formName = $data[0]['formName'];
                }
                    
            } else {
                
                //Если обёртка заполнена пользователем, открываем тэг обёртки. Иначе заполняем стандартно
                if( $data[$i]['wrapper'] != '' ) {
                    $body .= '<' . $data[$i]['wrapper'] . ' class="' . $data[$i]['wrapper_class'] . '" data-wow-delay=".' . $i . 's">';
                }else{
                    $body .= '<div class="form-group wow fadeInUp" data-wow-delay=".' . $i . 's">';
                }
                
                //Если label заполнен пользователем
                if( $data[$i]['label'] != '' ) {
                    $body .= '<label class="' . $data[$i]['label_class'] . '" for="field_' . $i . '">' . $data[$i]['label'] . '</label>';
                }
                
                //Разный html для input, textarea, submit
                if( $data[$i]['type'] === 'textarea' ) {
                    
                    $body .= '<textarea id="field_' . $i . '" class="' . $data[$i]['class'] . ' form-control" placeholder="' . $data[$i]['placeholder'] . '"></textarea>';
                    
                } else if($data[$i]['type'] === 'submit') {
                    
                    $buttonText = $data[$i]['placeholder'];
                    if ( $buttonText == '' ) {
                        $buttonText = 'Submit';
                    }
                    
                    $body .= '<button type="submit" id="field_' . $i . '" class="' . $data[$i]['class'] . '">' . $buttonText . '</button>';
                } else {
                    $body .= '<input type="' . $data[$i]['type'] . '" id="field_' . $i . '" class="' . $data[$i]['class'] . ' form-control" placeholder="' . $data[$i]['placeholder'] . '">';
                }
                
                //Закрытие тега обёртки
                if( $data[$i]['wrapper'] != '' ) {
                    $body .= '</' . $data[$i]['wrapper'] . '>';
                }else{
                    $body .= '</div>';
                }
            }
            
        }
        
        $result = $beginning . $body . $end;
        echo($result);
        return $result;
    }
    
    /**
    * Сохранение в файл
    */
    private function save_to_file(string $html)
    {
        $link   = plugin_dir_path( dirname( __FILE__ ) ) . 'storage/' . $this->formName . '.html';
        $result = file_put_contents($link, $html);
        return $result;
    }
}


/**
* По итогу получится html на подобии такого:
*
*    <form id="contact-form" role="form">
*        <div>
*			<div class="form-group wow fadeInUp">
*				<label class="sr-only" for="c_name">Name</label>
*				<input type="text" id="c_name" class="form-control" name="c_name" placeholder="Name">
*			</div>
*            
*			<div class="form-group wow fadeInUp" data-wow-delay=".1s">
*				<label class="sr-only" for="c_email">Email</label>
*				<input type="email" id="c_email" class="form-control" name="c_email" placeholder="E-mail">
*			</div>
*            
*			<div class="form-group wow fadeInUp" data-wow-delay=".2s">
*				<textarea class="form-control" id="c_message" name="c_message" rows="7" placeholder="Message"></textarea>
*			</div>
*            
*			<button type="submit" class="btn btn-lg btn-block wow fadeInUp" data-wow-delay=".3s">Send Message</button>
*		</div>
*	</form>
*/
