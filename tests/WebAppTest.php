<?php

# use Illuminate\Foundation\Testing\WithoutMiddleware;
# use Illuminate\Foundation\Testing\DatabaseTransactions;

class WebAppTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testLoginAndRegisterBusiness()
	{
		$this->visit('/lang/es');

		$this->visit('/')->see('Entrar');
		$this->click('Entrar')->see('Login')->see('Email')->see(htmlentities('Contraseña'));
		$this->type('alariva@gmail.com', 'email')
			 ->type('123123', 'password')
			 ->press('Ingresar')
			 ->seePageIs('user/businesses/list');

		$this->click('Mis Comercios')->click('Registrar Comercio')->see('Registrar un comercio');
		$this->type('HGNC', 'name')
			 ->type('Taller mecanico de Hernan GNC', 'description')
			 ->type('hgnc', 'slug')
			 ->select('America/Argentina/Buenos_Aires', 'timezone')
			 ->press('Actualizar');

		$this->visit('manager/business')
			 ->see('Mis Comercios')->see('HGNC')
			 ->click('hgnc')
			 ->see('Mis Clientes');
	}
}
