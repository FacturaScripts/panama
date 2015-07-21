<?php

/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2015  Carlos Garcia Gomez  neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_model('divisa.php');
require_model('pais.php');

/**
 * Description of admin_panama
 *
 * @author carlos
 */
class admin_panama extends fs_controller
{
   public function __construct()
   {
      parent::__construct(__CLASS__, 'Panamá', 'admin');
   }
   
   protected function private_core()
   {
      $this->share_extensions();
      
      if( isset($_GET['opcion']) )
      {
         if($_GET['opcion'] == 'moneda')
         {
            $div0 = new divisa();
            $divisa = $div0->get('USD');
            if(!$divisa)
            {
               $div0->coddivisa = 'USD';
               $div0->codiso = '840';
               $div0->descripcion = 'DÓLARES EE.UU.';
               $div0->simbolo = '$/.';
               $div0->tasaconv = 1.36;
               $div0->save();
            }
            
            $this->empresa->coddivisa = 'USD';
            if( $this->empresa->save() )
            {
               $this->new_message('Datos guardados correctamente.');
            }
         }
         else if($_GET['opcion'] == 'pais')
         {
            $pais0 = new pais();
            $pais = $pais0->get('PAN');
            if(!$pais)
            {
               $pais0->codpais = 'PAN';
               $pais0->codiso = 'PA';
               $pais0->nombre = 'Panamá';
               $pais0->save();
            }
            
            $this->empresa->codpais = 'PAN';
            if( $this->empresa->save() )
            {
               $this->new_message('Datos guardados correctamente.');
            }
         }
      }
   }
   
   private function share_extensions()
   {
      $fsext = new fs_extension();
      $fsext->name = 'pcge_panamá';
      $fsext->from = __CLASS__;
      $fsext->to = 'contabilidad_ejercicio';
      $fsext->type = 'fuente';
      $fsext->text = 'PCGE Panamá';
      $fsext->params = 'plugins/panama/extras/panama.xml';
      $fsext->save();
   }
}
