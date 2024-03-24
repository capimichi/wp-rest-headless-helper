<?php

/**
 * Interface ModuleInterface
 *
 * @package YourNamespaceHere
 */
interface ModuleInterface
{
    /**
     * Get the sort order of the module.
     *
     * @return mixed
     */
    public function getSort();
    
    /**
     * Initialize the module.
     *
     * @return void
     */
    public function initModule();
}