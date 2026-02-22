<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\Rate;
use Illuminate\Console\Command;

class UpdatePropertyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:update-to-350';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update property and rate records to use $350 per couple per night';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating property and rate records to $350 per couple...');

        // Update all properties
        $propertiesUpdated = Property::query()->update([
            'default_rate_per_couple' => 350,
        ]);

        $this->info("Updated {$propertiesUpdated} property record(s).");

        // Update all rates
        $ratesUpdated = Rate::query()->update([
            'rate_per_couple' => 350,
        ]);

        $this->info("Updated {$ratesUpdated} rate record(s).");

        // Display current values
        $property = Property::first();
        if ($property) {
            $this->info("\nCurrent property default_rate_per_couple: \${$property->default_rate_per_couple}");
        }

        $rate = Rate::first();
        if ($rate) {
            $this->info("Current rate rate_per_couple: \${$rate->rate_per_couple}");
        }

        $this->info("\n✓ All rates updated to \$350 per couple per night!");

        return Command::SUCCESS;
    }
}
