<?php

namespace App\Events;

use App\CatalogImport;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CatalogImportUpdated implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Information about import.
     *
     * @var CatalogImport
     */
    public $catalogImport;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CatalogImport $catalogImport)
    {
        $this->catalogImport = $catalogImport;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('App.CatalogImport.'.$this->catalogImport->id);
    }
}
