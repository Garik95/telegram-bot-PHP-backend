<?php
include("src/Autoloader.php");
$token = '339371115:AAEOSgOwRGXgndDMs1LF4VtjZF86vuNU0s8';
$bot = new Telegram\Bot($token, "test_GN_bot", "test_bot_GN");
$tg = new Telegram\Receiver($bot);
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$con = mysqli_connect('83.69.138.176', 'admin_novatio', '9UAeIFiJtf', 'admin_nova');
mysqli_set_charset($con,"utf8");
/*$sql  = 'SELECT * FROM ymd_categories where id>0 and parent_id = 0 and indx = 0';

$query  = mysqli_query($con, $sql);

                    while ($row = mysqli_fetch_array($query))
                    {
                      echo $row['name'];
                    }
*/
if($tg->callback)
{
  
  //$con = @mysqli_connect('localhost', 'somon_bot', 'Qxjg041*', 'somonitrading_bot');
  
  $sql  = 'SELECT * FROM sp_product `p` left outer join `sp_price` `pr` on `p`.`product_id` = `pr`.`product_id`';

    $query  = mysqli_query($con, $sql);

                  while ($row = mysqli_fetch_array($query))
                  {
            $res[] = $row['product_id'];
          }
  foreach($res as $r=>$val)
  {
  if($tg->callback == (string)$val){
    
    $encodedMarkup = '{"inline_keyboard": [[{"text": "➖","callback_data": "'.$val.'M"},{"text": "➕","callback_data": "'.$val.'P"},{"text": "🔙 Назад","callback_data": "'.$val.'back"}],[{"text": "🛒 Корзина","callback_data": "Bin"}]]}';
    $url = 'https://api.telegram.org/bot'.$token.'/editMessageReplyMarkup?chat_id='.$tg->chat->id.'&message_id='.$tg->message;
      $url .= '&reply_markup='.$encodedMarkup;
      $res = file_get_contents($url);
    $tg->answer_if_callback("Выберите количество");
    
  }elseif($tg->callback == (string)$val."d"){
     $tg->answer_if_callback(""); // Stop loading button.
     // $con = @mysqli_connect('localhost', 'somon_bot', 'Qxjg041*', 'somonitrading_bot');
       $sql  = 'select * from sp_product where product_id ='.$val;
       $query  = mysqli_query($con, $sql);
                  while ($row = mysqli_fetch_array($query))
                  {
                    $key = $row['product_Description'];
                  }
    $tg->send
    ->message(TRUE)
    ->chat(TRUE)
    ->text((string)$key)
    ->send();
  }elseif($tg->callback == (string)$val."P"){
    // $con = @mysqli_connect('localhost', 'somon_bot', 'Qxjg041*', 'somonitrading_bot');
    
    $check = 'select transaction_id,quantity from sp_transactions where client_id = '.$tg->user->id.' and product_id = '.$val;
    
    $ck  = mysqli_query($con, $check);
    
    $nr = mysqli_num_rows($ck);

    $prc = 'select Price from sp_price where product_id='.$val;
    $prc = mysqli_query($con, $prc);
    $obj = mysqli_fetch_object($prc);
    if($nr === 0){
      $qty = 1;
    $sql  = 'insert into sp_transactions (`client_id`,`product_id`,`price_id`,`quantity`) values ('.$tg->user->id.','.$val.','.$obj->Price.','.$qty.')';
    }else {
      $obj_qty = mysqli_fetch_object($ck);
      $qty = (int)$obj_qty->quantity+1;
      $sql = 'update sp_transactions set `quantity`='.$qty.' where `client_id`='.$tg->user->id.' and `product_id`='.$val;
    }
    if($con->query($sql) === TRUE){
      $tg->answer_if_callback($qty." штук(а) в корзине");
      }else{
      $tg->answer_if_callback("Ошибка в добавлении продукта в корзину. Повторите попытку позже 🙁");
      }
  }elseif($tg->callback == (string)$val."M"){
    // $con = @mysqli_connect('localhost', 'somon_bot', 'Qxjg041*', 'somonitrading_bot');
    
    $check = 'select transaction_id,quantity from sp_transactions where client_id = '.$tg->user->id.' and product_id = '.$val;
    
    $ck  = mysqli_query($con, $check);
    
    $nr = mysqli_num_rows($ck);

    $prc = 'select Price from sp_price where product_id='.$val;
    $prc = mysqli_query($con, $prc);
    $obj = mysqli_fetch_object($prc);
    $obj_qty = mysqli_fetch_object($ck);
    if((int)$obj_qty->quantity == 0){
      $tg->answer_if_callback("Выбранного продукта нету в корзине");
    }else {
      $qty = (int)$obj_qty->quantity-1;
      if($qty === 0)
      {
        $sql = 'delete from sp_transactions where `client_id`='.$tg->user->id.' and `product_id`='.$val;
      }else
      $sql = 'update sp_transactions set `quantity`='.$qty.' where `client_id`='.$tg->user->id.' and `product_id`='.$val;
    }
    if($con->query($sql) === TRUE){
      $tg->answer_if_callback($qty." штук(а) в корзине");
      }else{
      $tg->answer_if_callback("Ошибка в добавлении продукта в корзину. Повторите попытку позже 🙁");
      }
  }elseif($tg->callback == (string)$val."back"){
    $encodedMarkup = '{"inline_keyboard": [[{"text": "💲 Купить!","callback_data": "'.$val.'"},{"text": "🔍 Подробно...","callback_data": "'.$val.'d"}],[{"text": "🛒 Корзина","callback_data": "Bin"}]]}';
    $url = 'https://api.telegram.org/bot'.$token.'/editMessageReplyMarkup?chat_id='.$tg->chat->id.'&message_id='.$tg->message;
      $url .= '&reply_markup='.$encodedMarkup;
      $res = file_get_contents($url);
  }
  }
  if($tg->callback == "Bin"){
    $tg->answer_if_callback("");
    $sql = 'SELECT quantity,price_id,product_id,(select product_name from sp_product p where p.product_id=t.product_id) as product FROM `sp_transactions` t WHERE client_id ='. $tg->user->id;
      $query  = mysqli_query($con, $sql);
                  while ($row = mysqli_fetch_array($query))
                  {
                    $cart[] = array($row['product'],$row['quantity'],$row['price_id']);
                  }
      $sql = 'SELECT sum(price_id*quantity) as sum FROM `sp_transactions` WHERE client_id ='.$tg->user->id;
      $query  = mysqli_query($con, $sql);
      $s = mysqli_fetch_object($query);
      $str = "<b>Список продуктов в корзинке:</b>\n";
      $i = 1;
      foreach($cart as $c)
      {
        $str = $str ."<i>".$i.") ". $c[0] ."\n". $c[1] ."x".$c[2]."=".$c[1]*$c[2]." Сум</i>\n";
        $i++;
      }
      $str = $str ."Общая сумма: ". (int)$s->sum . " Сум\n";
      $tg->send->text($str,"html")->inline_keyboard()
      ->row()
        ->button("Оформить заказ","offer")
      ->end_row()
    ->show()->send();
  }
  if($tg->callback == "offer"){
    $tg->answer_if_callback("");
    
      $sql = 'SELECT quantity,price_id,product_id,(select product_name from sp_product p where p.product_id=t.product_id) as product FROM `sp_transactions` t WHERE client_id ='. $tg->user->id;
      $query  = mysqli_query($con, $sql);
                  while ($row = mysqli_fetch_array($query))
                  {
                    $cart[] = array($row['product'],$row['quantity'],$row['price_id']);
                  }
      $sql = 'SELECT sum(price_id*quantity) as sum FROM `sp_transactions` WHERE client_id ='.$tg->user->id;
      $query  = mysqli_query($con, $sql);
      $s = mysqli_fetch_object($query);
      $str = "";
      foreach($cart as $c)
      {
        $str = $str . $c[0] ."\n". $c[1] ."x".$c[2]."=".$c[1]*$c[2]." Сум\n";
      }
      $sum = (int)$s->sum;
      $sum = $sum * 100;
    
    $chat_id = $tg->chat->id;
    $title = "Оформление заказа";
    $description = urlencode($str);
    $provider_token = '398062629:TEST:999999999_F91D8F69C042267444B74CC0B3C747757EB0E065';
    $start_parameter = 'start_parameter';
    $url = 'https://api.telegram.org/bot'.$token.'/sendInvoice?chat_id='.$chat_id.'&title='.$title.'&description='.$description.'&payload=payload&provider_token='.$provider_token.'&start_parameter='.$start_parameter.'&currency=UZS&prices=[{"label":"Общая сумма","amount":'.$sum.'},{"label":"Скидка","amount":0}]&photo_url=https://somonitrading.com/tg/logo.png&photo_width=100&photo_height=100&need_email=true';
      $res = file_get_contents($url);
  }
  
}
if(array_key_exists('update_id',$update))
{
  $url = 'https://api.telegram.org/bot'.$token.'/answerPreCheckoutQuery?pre_checkout_query_id='.$update["pre_checkout_query"]["id"].'&ok=true';
  $res = file_get_contents($url);
}

if($tg->text()){
    // $con = @mysqli_connect('localhost', 'somon_bot', 'Qxjg041*', 'somonitrading_bot');
    
    $chusr = "Select userid from sp_users where userid = ". $tg->user->id;

    $query_chusr  = mysqli_query($con, $chusr);
          if(mysqli_num_rows($query_chusr) === 0){
            $sql = "INSERT INTO sp_users (userid,first_name, last_name, language_code,username,status) VALUES ('".$tg->user->id."', '".$tg->user->first_name."', '".$tg->user->last_name."','".$tg->user->language_code."','".$tg->user->username."',1)";
            $con->query($sql);
          }   

    $sql  = 'SELECT distinct(name) as name,category,product_name FROM sp_menu where name IS NOT NULL UNION SELECT distinct(command) as command ,category,product_name FROM sp_menu where command IS NOT NULL';

    $query  = mysqli_query($con, $sql);
  
                    $text_reply = "Please select a category...";
                  while ($row = mysqli_fetch_array($query))
                  {
                    $key[] = array($row['name'],$row['category'],$row['product_name']);
                  }
  foreach($key as $k=>$val)
  {
    if($val[0] == $tg->text())
   {
    if($tg->text() === "/start" || $tg->text() === "Назад")
    {
      $sql  = 'SELECT * FROM ymd_categories where id>0 and parent_id = 0 and indx = 0';

      $query  = mysqli_query($con, $sql);
      $user_id = $tg->user->id;
                  $text_reply = "Please select a category...";
                    unset($key);
                    while ($row = mysqli_fetch_array($query))
                    {
                      $key[] = array($row['name']);
                    }
                    $sql  = 'SELECT * FROM ymd_categories where id>0 and parent_id=0 and indx = 1';
                    $query  = mysqli_query($con, $sql);
                    $in = 0;
                    while ($row = mysqli_fetch_array($query))
                    {
                        if($in === 2) {
                          $key[] = array($item['0'],$item['1']);
                          $in=0;
                        }
                        $item[$in] = $row['name'];
                        $in++;
                    }
                    $replyMarkup = array(
                        'keyboard' => $key,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                      );
                    $encodedMarkup = json_encode($replyMarkup);
      $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$user_id;
      $url .= '&text=' .$text_reply. '&reply_markup='.$encodedMarkup;
      $res = file_get_contents($url);
    }elseif($tg->text() === "Корзинка")
    {
      $sql = 'SELECT quantity,price_id,product_id,(select product_name from sp_product p where p.product_id=t.product_id) as product FROM `sp_transactions` t WHERE client_id ='. $tg->user->id;
      $query  = mysqli_query($con, $sql);
                  while ($row = mysqli_fetch_array($query))
                  {
                    $cart[] = array($row['product'],$row['quantity'],$row['price_id']);
                  }
      $sql = 'SELECT sum(price_id*quantity) as sum FROM `sp_transactions` WHERE client_id ='.$tg->user->id;
      $query  = mysqli_query($con, $sql);
      $s = mysqli_fetch_object($query);
      $str = "<b>Список продуктов в корзинке:</b>\n";
      foreach($cart as $c)
      {
        $str = $str ."<i>". $c[0] ."\n". $c[1] ."x".$c[2]."=".$c[1]*$c[2]." Сум</i>\n";
      }
      $str = $str ."Общая сумма: ". (int)$s->sum . " Сум\n";
      $tg->send->text($str,"html")->inline_keyboard()
      ->row()
        ->button("Оформить заказ","offer")
      ->end_row()
    ->show()->send();
    }
    elseif($val[1] === 'Команды')
      {
        $sql = 'select distinct(name) as name from sp_menu where category= "'. $tg->text().'"';
         $query  = mysqli_query($con, $sql);
         $user_id = $tg->user->id;
         $text_reply = "Please select a subcategory...";
         unset($key);
         $key[] = array("Назад");
                  while ($row = mysqli_fetch_array($query))
                  {
                    $key[] = array($row['name']);
                  }
                  
                  $replyMarkup = array(
                      'keyboard' => $key,
                      'resize_keyboard' => true,
                    );

                  $encodedMarkup = json_encode($replyMarkup);
  $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$user_id;
  $url .= '&text=' .$text_reply. '&reply_markup='.$encodedMarkup;
  $res = file_get_contents($url);
      }
      elseif($tg->text() === "Вопрос к Диетологу")
      {
         $tg->send->text("Напишите ваш вопрос ниже (Начните вопрос с #diet. Пример вопроса #diet Кто такой Диетолог?):")->send();
      }
//----------------to get list of products--------------------
      else
      {
        $sql  = 'SELECT * FROM sp_product `p` left outer join `sp_price` `pr` on `p`.`product_id` = `pr`.`product_id` where sp_category_id = (select id from ymd_categories where name ="'.$tg->text().'")';

          $query  = mysqli_query($con, $sql);
          if(mysqli_num_rows($query) === 0) {
            $tg->send->text('Пока этот меню пуст...')->send();
          }else{
                        while ($row = mysqli_fetch_array($query))
                        {
            $tg->send
              ->text((string)$row['product_name']." - Цена: ".$row['Price'] ." Сум" )
              ->inline_keyboard()
            ->row()
              ->button("💲 Купить!",(string)$row['product_id'])
          ->button("🔍 Подробно...",(string)$row['product_id']."d")
            ->end_row()
          ->row()
              ->button("🛒 Корзина","Bin")
            ->end_row()
          ->show()->file("photo",(string)$row['product_Photo']);
                } 
                }   
      } break;
   }
   elseif($tg->text_has("#diet"))
      {
         $question = substr($tg->text(), 6);
         $sql = "INSERT INTO sp_questions (user_id,message_id,target_message_id,category,question) VALUES ('".$tg->user->id."',".$tg->message.",'".json_encode($tg)."',0, '".$question."')";
            $con->query($sql);
            $token_1 = '447080939:AAFVn76zbat7ngw08UOdhYNIjMIF6EI4fyk';
            $bot_1 = new Telegram\Bot($token_1, "novatio_diet_bot", "bot");
            $tg_1 = new Telegram\Receiver($bot_1);
         $sql = "select * from staff";
         $query  = mysqli_query($con, $sql);
         // $query = mysqli_fetch_array($query);

         $sql1 = "select max(id) as maxid from sp_questions where user_id=".$tg->user->id;
         $query1  = mysqli_query($con, $sql1);
         $query1 = mysqli_fetch_array($query1);
         $str = "#".$tg->user->id."-".$tg->message."\n <b>".$tg->user->first_name." ".$tg->user->last_name."</b> \n".$question;
         // $q = 1;
         while($q = mysqli_fetch_array($query))
        {    
          // $tg_1->send->text($q['staff_id'])->send();
          // $q ++;
          $tg_1->send
                      ->text($str,"html")
                      ->chat((string)$q['staff_id'])
                      ->inline_keyboard()
                    ->row()
                      ->button("Ответить",(string)$query1['maxid']."ans")
                       ->button("Закрыть",(string)$query1['maxid']."cls")
                    ->end_row()
                  ->show()->send();
        }
          // $tg->send->text(json_encode($tg->message))->send();
          // $tg_1->send->text(json_encode($tg_1->message)->send();
          $tg->send->text($tg->user->first_name.", Я ваш вопрос отправил Диетологу))))")->send();
            break;
      }
  
  }
}


/*  
if($tg->text_has("123")){

        //$text = "123";
  
  $con = @mysqli_connect('localhost', 'somon_bot', 'Qxjg041*', 'somonitrading_bot');
  
    $sql  = 'SELECT * FROM sp_category';

    $query  = mysqli_query($con, $sql);
  
                    $text_reply = "Please select a category...";
                  while ($row = mysqli_fetch_array($query))
                  {
                    $key[] = $row['name'];
                  }
  foreach($key as $k)
  {
    if($k == "Сэты")
    $tg->send->text((string)$k)->send();
    /*switch($text)
      case $k[0]: $tg->send->text($text)->send(); break;
    default: break;
  }
}
*/
/*if($tg->text_has("ph")){
  //for($i=1;i<=3;i++){
  $i=1;
  while($i<3){
    $tg->send->inline_keyboard()
      ->row()
        ->button((string)$i, "but 1")
        ->button("Blue", "but 2")
      ->end_row()
    ->show()->file("photo","AgADAgADOqgxG70RAUl4K2z14n970B4wSw0ABIKVDAcPeBvjKnQOAAEC"); $i++;}
}
*/

/*if($tg->text_has("cat"))
{
$con = @mysqli_connect('localhost', 'somon_bot', 'Qxjg041*', 'somonitrading_bot');

    if (!$con) {
      $tg->send->text("failed")->send();
  }
  else $tg->send->text("success")->send();
  
      $sql  = 'SELECT * FROM sp_category';

    $query  = mysqli_query($con, $sql);
  
  $text_reply = "Please select a category...";

  $user_id = $tg->user->id;
                  while ($row = mysqli_fetch_array($query))
                  {
                    $key[] = array($row['name']);
                  }
                  $replyMarkup = array(
                      'keyboard' => $key,
                      'resize_keyboard' => true,
                      'one_time_keyboard' => true
                    );
                  $encodedMarkup = json_encode($replyMarkup);
    //$tg->send->text("Please select a category...")->send();
    //$tg->send->text()->send();

  $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$user_id;
  $url .= '&text=' .$text_reply. '&reply_markup='.$encodedMarkup;
  $res = file_get_contents($url);

}*/

?>