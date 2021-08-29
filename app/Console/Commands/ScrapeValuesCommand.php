<?php

namespace App\Console\Commands;

use App\Interfaces\CardVersionServiceInterface;
use App\Models\ReleasedCardVersion;
use Illuminate\Console\Command;

class ScrapeValuesCommand extends Command
{
    protected $signature = 'scrape:values';
    protected $description = 'Scrape Values';

    private CardVersionServiceInterface $cardVersionService;

    public function handle(
        CardVersionServiceInterface $cardVersionService
    ): int {
        $this->cardVersionService = $cardVersionService;

        $this->info('Scraping values...');

        $versions = ReleasedCardVersion::query()
            ->where('value', null)
            ->orWhere('value', '<=', 0)
            ->orderBy('updated_at', 'DESC')
            ->get();

        foreach($versions as $version) {
            $card = $version->releasedCard;
            $cardNumber = $card->paddedNumber();
            $cardName = $card->name;
            $setName = $card->set->name;

            echo "Searching '$setName $cardName $cardNumber'\n";

            $value = $this->cardVersionService->scrapeValue($version->id);

            if ($value > 0) {
                echo "Value is: £$value\n";
            } else {
                echo "Value not found\n";
            }
        }

        $this->info('Done');

        return 0;
    }
}
