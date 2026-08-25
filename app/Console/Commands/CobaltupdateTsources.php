<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Admark\Cobalt\CobaltService;
use Admark\Tracking\Http\Repositories\TsourceRepository;
use Admark\Tracking\Http\Models\Tsource;

class CobaltupdateTsources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cobalt:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los tsources con cobalt';

    protected $cobalt;
    protected $tsources;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        CobaltService $cobaltService,
        TsourceRepository $tsourceRepository
    )
    {
        parent::__construct();

        $this->cobalt = $cobaltService;
        $this->tsources = $tsourceRepository;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->updateAllTsources();
        $this->updateDefaultTsource();

        return 0;
    }


    private function updateDefaultTsource(): void
    {
        $tsourceDefaultId = $this->cobalt->getDefaultTsource(
            '0',
            config('cobalt.default.microsite'),
            '',
            ''
        );

        $tsourceDefault = Tsource::where(
            'tsource',
            $tsourceDefaultId
        )->first();

        if ($tsourceDefault === null) {
            $this->error(
                "No se encontró la tsource por defecto {$tsourceDefaultId}"
            );

            return;
        }

        $tsourceZero = Tsource::updateOrCreate(
            ['tsource' => 0],
            [
                'phone' => $tsourceDefault->phone,
                'priority' => 500,
                'provider' => 'telemark-interno',
            ]
        );

        $this->info(
            $tsourceZero->wasRecentlyCreated
                ? 'NEW TSOURCE: 0'
                : 'EXISTENT TSOURCE: 0'
        );
    }

    private function updateAllTsources(){

        $tsourcesArray = $this->cobalt->getTsources();

        foreach ($tsourcesArray as $tsource => $tsourceData){

            $tsourceModel = Tsource::where('tsource','=',$tsource)->first();
            $phone = ($tsourceData['phone'] === null)?'0':$tsourceData['phone'];

            if($tsourceModel === null){

                $tsourceModel = new Tsource([
                    'tsource' => $tsource,
                    'phone' => $phone
                ]);

                $tsourceModel->save();

                $this->info("NEW TSOURCE: $tsource");

            }else{

                $tsourceModel->phone = $phone;
                $tsourceModel->save();

                $this->info("EXISTENT TSOURCE: $tsource");

            }

        }

    }
}
