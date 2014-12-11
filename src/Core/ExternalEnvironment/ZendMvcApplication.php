<?php
/*
 * Teon PHP Base
 *
 * Copyright (C) 2012-2014 Teon d.o.o.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



/*
 * Namespace defition
 */
namespace Teon\Base\Core\ExternalEnvironment;



/*
 * Class definition
 */
class        ZendMvcApplication
implements   ExternalEnvironmentInterface
{



     /*
     * Import trait: singleton factory
     */
    use \Teon\Base\Singleton\SingletonFactoryTrait;



    /*
     * Store reference external application
     *
     * @var   \Zend\Mvc\Application
     */
    protected $Application;




    /*
     * 
     *
     * @return   string
     */
    public function _init ($Application)
    {
        $this->Application = $Application;
    }



    /*
     * Return remote IP address
     *
     * @return   string
     */
    public function getRemoteIpAddr ()
    {
        return $this->Application->getRequest()->getServer()->get('REMOTE_ADDR');
    }
}
