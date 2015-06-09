<?php
namespace Services\HelloWorld;

use Fantasy\Model\UserModel;
class HelloWorldHandler implements HelloWorldIf {
  public function sayHello($name)
  {
      try {
          return "Hello $name".UserModel::fantasyUserLogin();
      } catch (\Exception $e) {
          return $e->getMessage();
      }
      return 'null';
  }

  public function sayAge($age) {
     return "age $age";
  }
}
