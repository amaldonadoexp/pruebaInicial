<?php

function show($message){
    echo "<p>$message</p>";
}

abstract class Unit
{
    protected $name;
    //protected $alive=true;
    protected $hp = 100;

    public function __construct($name)
    {

        $this->name = $name;
    }

    public function move($direction)
    {

        echo "<b> {$this->name} camina hacia $direction</b><br/>";
    }

    public function getName()
    {

        return $this->name;
    }

    public function getHp()
    {

        return $this->hp;
    }

    public function die()
    {

        echo ("{$this->name} muere <br/>");
        exit();
    }

    public function takeDamage($damage)
    {

        $this->hp = ($this->hp - $this->absorbDamage($damage));
        if ($this->hp <= 0) {
            $this->die();
            
        }else{
            echo ("{$this->name} ahora tiene {$this->hp} puntos de vida<br/>");

        }
    }
    protected function absorbDamage($damage)
    {
        return $damage;
    }

    abstract protected function attack(Unit $opponent);
}



class Soldier extends Unit
{
    protected $damage = 40;
    protected $armor = null;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->setArmor();

    }

    public function setArmor(Armor $armor = null)
    {
        $this->armor = $armor;
    }

    public function attack(Unit $opponent)
    {

        echo "{$this->name} <b>apuñala a {$opponent->getName()} mortalmente.</b><br/>";

        $opponent->takeDamage($this->damage);
    }

    public function takeDamage($damage)
    {

        if ($this->armor) {
            $damage = $this->armor->absorbDamage($damage);
        }
        return parent::takeDamage($damage / 2);
    }
protected function absorbDamage($damage)
{
    if($this->armor){
        $damage = $this->armor->absorbDamage($damage);
    }
    return $damage;
}
 
}


class Archer extends Unit
{
    protected $damage = 20;
    protected $armor = null;

    public function attack(Unit $opponent){

        echo "{$this->name} <b>dispara una flecha a {$opponent->getName()} </b><br/>";
        $opponent->takeDamage($this->damage);
    }

    public function takeDamage($damage)
    {

        if (rand(0, 1)) {
            return parent::takeDamage($damage);
        }
    }

    protected function absorbDamage($damage)
    {
        if(rand(0,1)){
          $damage = 0;
          return $damage;
        }
            return $damage;
        
    }
}

interface Armor
{

    public function absorbDamage($damage);
}

class BronzeArmor implements Armor
{

    public function absorbDamage($damage)
    {

        return $damage / 2;
    }
}


class SilverArmor implements Armor
{

    public function absorbDamage($damage)
    {
        return $damage / 2;
    }
}

class CursedArmor implements Armor
{

    public function absorbDamage($damage)
    {
        return $damage * 2;
    }
}

$armor = new BronzeArmor();
$rambo = new Soldier("rambo");
$swag = new Archer("swag");
$rambo->setArmor($armor);

$rambo->move("el sur");
$rambo->attack($swag);

$swag->attack($rambo);
$rambo->attack($swag);
$rambo->attack($swag);
$rambo->attack($swag);

?>