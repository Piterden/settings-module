<?php namespace Anomaly\SettingsModule\Setting\Contract;

use Anomaly\SettingsModule\Setting\SettingModel;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

/**
 * Interface SettingRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SettingsModule\SettingInterface\Contract
 */
interface SettingRepositoryInterface extends EntryRepositoryInterface
{

    /**
     * Get a setting.
     *
     * @param $key
     * @return null|SettingInterface|SettingModel
     */
    public function get($key);

    /**
     * Set a settings value.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value);

    /**
     * Get a setting value.
     *
     * @param      $key
     * @param null $default
     * @return mixed|null
     */
    public function value($key, $default = null);

    /**
     * Return the field type
     * presenter for a setting.
     *
     * @param $key
     * @return FieldTypePresenter|null
     */
    public function presenter($key);

    /**
     * Find a setting by it's key
     * or return a new instance.
     *
     * @param $key
     * @return SettingInterface
     */
    public function findByKeyOrNew($key);
}
