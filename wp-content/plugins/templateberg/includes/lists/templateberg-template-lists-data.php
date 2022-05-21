<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Templateberg
 * @author     Templateberg <info@templateberg.com>
 */
class Templateberg_Template_Lists_Data
{

    public $data = [];
    public $tab = 'block';
    public $bCats= [];
    public $bFreeCats= [];
    public $bProCats= [];
    public $tCats= [];
    public $tFreeCats= [];
    public $tProCats= [];
    public $tkCats= [];
    public $tkFreeCats= [];
    public $tkProCats= [];
    public $countItems= [];
    public $countFreeItems= [];
    public $countProItems= [];
    public $tkCount= [];

    /*Theme*/
    public $allThemeCats= [];
    public $allThemeFreeCats= [];
    public $allThemeProCats= [];
    public $normalThemeCats= [];
    public $normalThemeFreeCats= [];
    public $normalThemeProCats= [];
    public $gutenbergThemeCats= [];
    public $gutenbergThemeFreeCats= [];
    public $gutenbergThemeProCats= [];
    public $fseThemeCats= [];
    public $fseThemeFreeCats= [];
    public $fseThemeProCats= [];
    public $elementorThemeCats= [];
    public $elementorThemeFreeCats= [];
    public $elementorThemeProCats= [];

    /**
     * Main Instance
     *
     * Insures that only one instance of Templateberg_Template_Lists_Data exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     *
     * @since    1.0.0
     * @access   public
     *
     * @return object
     */
    public static function instance()
    {

        // Store the instance locally to avoid private static replication
        static $instance = null;

        // Only run these methods if they haven't been ran previously
        if (null === $instance) {
            $instance = new self();
        }

        // Always return the instance
        return $instance;
    }

    public function set_counts($type, $o, $all = false)
    {

        if ($all) {
            if (!isset($this->countItems[$type]['all'])) {
                $this->countItems[$type]['all'] = 1;
            } else {
                $this->countItems[$type]['all']++;
            }
        } else {
            if (!isset($this->countItems[$type][$o])) {
                $this->countItems[$type][$o] = 1;
            } else {
                $this->countItems[$type][$o]++;
            }
        }
    }


    public function set_free_counts($type, $o, $all = false)
    {
        if ($all) {
            if (!isset($this->countFreeItems[$type]['all-free'])) {
                $this->countFreeItems[$type]['all-free'] = 1;
            } else {
                $this->countFreeItems[$type]['all-free']++;
            }
        } else {
            if (!isset($this->countFreeItems[$type][$o])) {
                $this->countFreeItems[$type][$o] = 1;
            } else {
                $this->countFreeItems[$type][$o]++;
            }
        }
    }

    public function set_pro_counts($type, $o, $all = false)
    {
        if ($all) {
            if (!isset($this->countProItems[$type]['all-pro'])) {
                $this->countProItems[$type]['all-pro'] = 1;
            } else {
                $this->countProItems[$type]['all-pro']++;
            }
        } else {
            if (!isset($this->countProItems[$type][$o])) {
                $this->countProItems[$type][$o] = 1;
            } else {
                $this->countProItems[$type][$o]++;
            }
        }
    }

    /**
     *  Run functionality with hooks
     *
     * @since    1.0.0
     * @access   public
     *
     * @return void
     */
    public function run($templates_list)
    {
        if (is_array($templates_list)) {
            foreach ($templates_list as $list) {
                $type = $list['type'];
                if (!isset($this->data[$type])) {
                    $this->data[$type] = [];
                }
                array_push($this->data[$type], $list);
                $this->set_counts($type, '', true);
                if (isset($list['is_pro'])) {
                    $this->set_pro_counts($type, '', true);
                } else {
                    $this->set_free_counts($type, '', true);
                }
                if (isset($list['categories'])) {
                    if ('template-kits' === $type) {
                        foreach ($list['categories'] as $cat) {
                            if (isset($list['is_pro'])) {
                                array_push($this->tkProCats, $cat);
                                $this->set_pro_counts($type, $cat);
                            } else {
                                array_push($this->tkFreeCats, $cat);
                                $this->set_free_counts($type, $cat);
                            }
                            array_push($this->tkCats, $cat);
                            $this->set_counts($type, $cat);
                        }
                    } elseif ('templates' === $type) {
                        foreach ($list['categories'] as $cat) {
                            if (isset($list['is_pro'])) {
                                array_push($this->tProCats, $cat);
                                $this->set_pro_counts($type, $cat);
                            } else {
                                array_push($this->tFreeCats, $cat);
                                $this->set_free_counts($type, $cat);
                            }
                            array_push($this->tCats, $cat);
                            $this->set_counts($type, $cat);
                        }
                    } elseif ('blocks' === $type) {
                        foreach ($list['categories'] as $cat) {
                            if (isset($list['is_pro'])) {
                                array_push($this->bProCats, $cat);
                                $this->set_pro_counts($type, $cat);
                            } else {
                                array_push($this->bFreeCats, $cat);
                                $this->set_free_counts($type, $cat);
                            }
                            array_push($this->bCats, $cat);
                            $this->set_counts($type, $cat);
                        }
                    }
                }

                /*Templates per Template kit Count*/
                if ('templates' === $type && isset($list['template_kit_id'])) {
                    if (!isset($this->tkCount[$list['template_kit_id']])) {
                        $this->tkCount[$list['template_kit_id']] = 1;
                    } else {
                        $this->tkCount[$list['template_kit_id']]++;
                    }
                }
            }
        }
    }

    /**
     * Setup WordPress Themes
     *
     * @since    1.0.0
     * @access   public
     *
     * @return void
     */
    public function setup_themes($themes_list)
    {
        $this->tab = 'all';
        $this->data['all'] = [];

        $this->tab = 'purchased';
        $this->data['purchased'] = [];

        if (is_array($themes_list)) {
            foreach ($themes_list as $list) {
                $type = $list['type'];
                if (!isset($this->data[$type])) {
                    $this->data[$type] = [];
                }
                array_push($this->data[$type], $list);
                $this->set_counts($type, '', true);

                array_push($this->data['all'], $list);
                $this->set_counts('all', '', true);

                if (isset($list['is_pro'])) {
                    $this->set_pro_counts($type, '', true);
                    $this->set_pro_counts('all', '', true);

                    /*Test*/
                    if (templateberg_is_current_theme_template_available($list)) {
                        array_push($this->data['purchased'], $list);
                        $this->set_counts('all', '', true);
                    }
                    /*Test*/
                } else {
                    $this->set_free_counts($type, '', true);
                    $this->set_free_counts('all', '', true);
                }
                if (isset($list['categories'])) {
                    foreach ($list['categories'] as $cat) {
                        if (isset($list['is_pro'])) {
                            array_push($this->allThemeProCats, $cat);
                            $this->set_pro_counts('all', $cat);
                        } else {
                            array_push($this->allThemeFreeCats, $cat);
                            $this->set_free_counts('all', $cat);
                        }
                        array_push($this->allThemeCats, $cat);
                        $this->set_counts('all', $cat);
                    }
                    if ('normal' === $type) {
                        foreach ($list['categories'] as $cat) {
                            if (isset($list['is_pro'])) {
                                array_push($this->normalThemeProCats, $cat);
                                $this->set_pro_counts($type, $cat);
                            } else {
                                array_push($this->normalThemeFreeCats, $cat);
                                $this->set_free_counts($type, $cat);
                            }
                        }
                        array_push($this->normalThemeCats, $cat);
                        $this->set_counts($type, $cat);
                    } elseif ('gutenberg' === $type) {
                        foreach ($list['categories'] as $cat) {
                            if (isset($list['is_pro'])) {
                                array_push($this->gutenbergThemeProCats, $cat);
                                $this->set_pro_counts($type, $cat);
                            } else {
                                array_push($this->gutenbergThemeFreeCats, $cat);
                                $this->set_free_counts($type, $cat);
                            }
                            array_push($this->gutenbergThemeCats, $cat);
                            $this->set_counts($type, $cat);
                        }
                    } elseif ('full-site-editing' === $type) {
                        foreach ($list['categories'] as $cat) {
                            if (isset($list['is_pro'])) {
                                array_push($this->fseThemeProCats, $cat);
                                $this->set_pro_counts($type, $cat);
                            } else {
                                array_push($this->fseThemeFreeCats, $cat);
                                $this->set_free_counts($type, $cat);
                            }
                            array_push($this->fseThemeCats, $cat);
                            $this->set_counts($type, $cat);
                        }
                    } elseif ('elementor' === $type) {
                        foreach ($list['categories'] as $cat) {
                            if (isset($list['is_pro'])) {
                                array_push($this->elementorThemeProCats, $cat);
                                $this->set_pro_counts($type, $cat);
                            } else {
                                array_push($this->elementorThemeFreeCats, $cat);
                                $this->set_free_counts($type, $cat);
                            }
                            array_push($this->elementorThemeCats, $cat);
                            $this->set_counts($type, $cat);
                        }
                    }
                }
            }
        }
    }

    public function get_type()
    {
        if ($_GET['type']) {
            return $_GET['type'];
        } else {
            return 'block';
        }
    }
}

if (! function_exists('templateberg_template_lists_data')) {

    function templateberg_template_lists_data()
    {
        return Templateberg_Template_Lists_Data::instance();
    }
}
