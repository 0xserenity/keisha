<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CreateShoeFromJsonTest extends TestCase
{
    public function test_that_true_is_true()
    {

    }

    public function getResponseFromStepn(): string
    {
        return '{"code":0,"data":{"id":52709389767,"state":1230,"type":3,"dataID":100102,"chain":103,"level":0,"quality":1,"hp":100,"isRun":false,"remain":0,"attrs":[24,65,11,32,0,0,0,0,0,0,0,0],"endTime":0,"upLeveTime":3600000,"coolDownE":86400000,"canSend":false,"price":0,"speedMin":223,"speedMax":556,"breed":0,"breedT":1662696504501,"otd":630076645,"hpLimit":100,"isTest":false,"shoeImg":"30/43/m218706_49885ee4847a9cc5ffb27ba3b14c88a66211_67.png","lifeRatio":10000,"relatives":[{"type":1,"otd":527397489,"dataId":100102,"img":"6/5/m218706_14b4d815b5c3e6a2a232c34680c4deccc1dc_67.png","shoeId":198963043493},{"type":1,"otd":168888888,"dataId":100059,"img":"20/14/m2186db_8867ffd532888815ffa7f7936c4535888805_67.png","shoeId":66160576369}],"holes":[{"index":0,"type":2,"quality":-1,"price":0,"dataID":0,"gemId":0,"addv":0,"gAddv":0,"hAddv":0},{"index":1,"type":2,"quality":-1,"price":0,"dataID":0,"gemId":0,"addv":0,"gAddv":0,"hAddv":0},{"index":2,"type":2,"quality":-1,"price":0,"dataID":0,"gemId":0,"addv":0,"gAddv":0,"hAddv":0},{"index":3,"type":3,"quality":-1,"price":0,"dataID":0,"gemId":0,"addv":0,"gAddv":0,"hAddv":0}]}}';
    }
}
