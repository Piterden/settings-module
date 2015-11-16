<?php namespace Anomaly\SettingsModule\Setting;

use Anomaly\SettingsModule\Setting\Contract\SettingInterface;
use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Illuminate\Config\Repository;

/**
 * Class SettingRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SettingsModule\SettingInterface
 */
class SettingRepository extends EntryRepository implements SettingRepositoryInterface
{

    /**
     * The setting model.
     *
     * @var SettingModel
     */
    protected $model;

    /**
     * The settings collection.
     *
     * @var SettingCollection
     */
    protected $settings;

    /**
     * Create a new SettingRepositoryInterface instance.
     *
     * @param SettingModel        $model
     * @param Repository          $config
     * @param FieldTypeCollection $fieldTypes
     */
    public function __construct(SettingModel $model)
    {
        $this->model = $model;

        $this->settings = $this->model->all();
    }

    /**
     * Get a setting.
     *
     * @param $key
     * @return null|SettingInterface
     */
    public function get($key)
    {
        return $this->settings->get($key);
    }

    /**
     * Set a settings value.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value)
    {
        $setting = $this->findByKeyOrNew($key);

        $setting->setValue($value);

        return $this->save($setting);
    }

    /**
     * Get a setting value.
     *
     * @param      $key
     * @param null $default
     * @return mixed|null
     */
    public function value($key, $default = null)
    {
        if ($setting = $this->get($key)) {
            return $setting->getValue();
        }

        return $default;
    }

    /**
     * Return the field type
     * presenter for a setting.
     *
     * @param $key
     * @return FieldTypePresenter|null
     */
    public function presenter($key)
    {
        if ($setting = $this->get($key)) {
            return $setting->getFieldTypePresenter('value');
        }

        return null;
    }

    /**
     * Find a setting by it's key
     * or return a new instance.
     *
     * @param $key
     * @return SettingInterface
     */
    public function findByKeyOrNew($key)
    {
        if (!$setting = $this->model->where('key', $key)->first()) {

            $setting = $this->model->newInstance();

            $setting->setKey($key);
        }

        return $setting;
    }

    /**
     * Find all settings with namespace.
     *
     * @param $namespace
     * @return SettingCollection
     */
    public function findAllByNamespace($namespace)
    {
        return $this->model->where('key', 'LIKE', $namespace . '%')->get();
    }
}
