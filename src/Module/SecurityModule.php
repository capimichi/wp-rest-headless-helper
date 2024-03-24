<?php

class SecurityModule implements ModuleInterface
{
    
    /**
     * @inheritDoc
     */
    public function getSort()
    {
        return 100;
    }
    
    /**
     * @inheritDoc
     */
    public function initModule()
    {
        add_action('pre_get_posts', [$this, 'filterForAuthenticatedUserOnPosts']);
    }
    
    protected function filterForAuthenticatedUserOnPosts($query)
    {
        if (is_admin()) {
            return;
        }
        
        // Ottieni l'ID dell'utente attualmente autenticato
        $currentUserId = get_current_user_id();
        if (!$currentUserId) {
            $currentUserId = -1;
        }
        
        // Aggiungi il filtro per mostrare solo i post associati all'utente autenticato
        $query->set('author', $currentUserId);
    }
}