<?php

use Illuminate\Database\Seeder;
use Fenos\Notifynder\Facades\Notifynder;

class NotifynderCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notifynder::addCategory('user.visitedShowroom', '{from.username} visited showroom');
        Notifynder::addCategory('user.registeredBusiness', '{from.username} registered :business');
        Notifynder::addCategory('user.suscribedBusiness', '{from.username} suscribed to business');
        Notifynder::addCategory('user.checkingVacancies', '{from.username} checks vacancies');
        Notifynder::addCategory('user.updatedBusinessPreferences', '{from.username} updated :business preferences');
        Notifynder::addCategory('user.importedContacts', '{from.username} imported :count contacts');
        Notifynder::addCategory('appointment.reserve', '{from.username} made a reservation for :business');
        Notifynder::addCategory('appointment.annulate', '{from.username} annulated appointment');
        Notifynder::addCategory('appointment.confirm', '{from.username} confirmed appointment');
        Notifynder::addCategory('appointment.serve', '{from.username} served appointment');
    }
}
