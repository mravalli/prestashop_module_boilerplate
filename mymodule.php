<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to mario@raval.li so I can send you a copy immediately.
 *
 * @author    Mario Ravalli <mario@raval.li>
 * @copyright Since 2023 Mario Ravalli
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

use Language;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;

if (!defined('_PS_VERSION_')) {
    exit;
}

class MyModule extends Module
{
    const SQL_FILE = 'install.sql';

    public function __construct()
    {
        $this->name = 'mymodule';
        $this->tab = 'front_office_features';
        $this->version = '0.0.1';
        $this->author = 'Your Name';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.7.6', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('My Module', [], 'Modules.Mymodule.Mymodule');
        $this->description = $this->trans('Allow users to do something.', [], 'Modules.Mymodule.Mymodule');

        require_once __DIR__ . '/vendor/autoload.php';

        $this->installTab();
    }

    public function install(): bool
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!$sql = file_get_contents(dirname(__FILE__) . '/' . self::SQL_FILE)) {
            return false;
        }
        $sql = str_replace(['PREFIX_', 'ENGINE_TYPE'], [_DB_PREFIX_, _MYSQL_ENGINE_], $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute(trim($query))) {
                return false;
            }
        }

        return parent::install();
    }

    public function uninstall()
    {
        if (!parent::uninstall() || !$this->deleteTables()) {
            return false;
        }

        return (
            parent::uninstall()
            && Configuration::deleteByName('MYMODULE_CONFIG')
        );
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            $configValue = (string) Tools::getValue('MYMODULE_CONFIG');

            if (empty($configValue) || !Validate::isGenericName($configValue)) {
                $output = $this->displayError($this->l('Invalid Configuration value'));
            } else {
                Configuration::updateValue('MYMODULE_CONFIG', $configValue);
                $output = $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        return $output . $this->displayForm();
    }

    public function displayForm()
    {
        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Configuration value'),
                        'name' => 'MYMODULE_CONFIG',
                        'size' => 20,
                        'required' => true,
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                ],
            ],
        ];

        $helper = new HelperForm();

        $helper->table = $this->table;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&' . http_build_query(['configure' => $this->name]);
        $helper->submit_action = 'submit' . $this->name;

        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');

        $helper->fields_value['MYMODULE_CONFIG'] = Tools::getValue(
            'MYMODULE_CONFIG',
            Configuration::get('MYMODULE_CONFIG')
        );

        return $helper->generateForm([$form]);
    }

    private function deleteTables()
    {
        return Db::getInstance()->execute('
            DROP TABLE IF EXISTS 
            `' . _DB_PREFIX_ . 'mymodule_boiler`,
            `' . _DB_PREFIX_ . 'mymodule_plate`
        ');
    }

    protected function generateControllerURI()
    {
        $router = SymfonyContainer::getInstance()->get('router');

        return $router->generate('mymodule_route');
    }

    private function installTab()
    {
        $this->tabs = [
            [
                'route_name' => 'mymodule_route',
                'class_name' => 'AdminMyModuleBoilerplate',
                'visible' => true,
                'name' => $tabNames,
                'parent_class_name' => 'SELL',
                'wording' => 'Boilerplate',
                'wording_domain' => 'Modules.Mymodule.Mymodule'
            ],
        ];
    }
}
