<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        $equipmentNames = [
            "ZenithBook 1500", "OptiMate X", "TerraByte Z2", "AeroBook Pro", "CyberEdge M100", "QuantumPad 14",
            "TitanBolt X1", "AlphaVibe Z300", "HyperNova Pro", "TechMaster Slim", "GigaFlex Ultra", "FusionCore S2",
            "PowerEdge V100", "CosmoPad Elite", "UltraVision 5", "MagnoBook Max", "VortexBlade 17", "PixelWave XR",
            "StormForce G5", "VelocityNote 12", "NeonTech Ultra", "NebulaCore Mx", "SpectraView Y1", "InfiBook Pro",
            "NanoByte Max", "ProGlide Slim", "HyperTech Vibe", "AlphaFusion 300", "VisionPad Pro", "ChronoEdge 15",
            "FlexPad Infinity", "UltraNova Z7", "XenithBook 400", "TechForce Ultra", "QuantumEdge 12", "VeloNote Pro",
            "DynamiBook Elite", "TitanBlade 11", "SpectraCore M2", "TerraNote Z", "AstroPad Slim", "LumiFlex Pro",
            "Celeronix Ultra", "AlphaMax Z15", "VegaBook M1", "ProtoFlex Slim", "MaxiTech X", "HyperByte 200",
            "OmegaWave S", "GigaBook V5", "ZenithEdge Pro", "TurboPad 13", "FusionWave XR", "PixelCore S12",
            "PowerByte Max", "VisionFlex G2", "VelocityMax Pro", "ChronoPad Ultra", "AlphaCore Z8", "OptiBook Max",
            "UltraVibe 15", "GigaBlade Pro", "TechnoEdge X", "VortexPad Y7", "StormBook Elite", "CosmoCore Ultra",
            "HyperBlade Z", "NeonPad 12", "CyberTech Pro", "TitanNote V", "AlphaEdge XR", "NebulaNote 14",
            "PixelMate Ultra", "FusionNote M1", "MaxiCore Slim", "UltraByte Z5", "VisionNote Elite", "CeleronPad Pro",
            "GigaVibe M10", "LumiTech Max", "ZenithMate X1", "HyperNote Ultra", "OmegaEdge Pro", "QuantumBook 13",
            "AlphaWave S2", "ProtoBlade Max", "AstroBook Slim", "TurboNote G1", "UltraCore X5", "CosmoNote 15",
            "NeonFlex Vibe", "PowerTech 200", "VegaEdge Pro", "MaxiPad Elite", "HyperVision Z", "TitanWave 300",
            "VisionCore X1", "QuantumPad Ultra", "TechMaster Pro", "FusionEdge 14", "PixelFlex Mx", "ChronoBook G3"
        ];

        return [
            'equipment_name' => fake()->unique()->randomElement($equipmentNames),
            'equipment_type' => fake()->randomElement(['Server', 'Computer', 'Printer', 'Network Device', 'Other']),
            'model' => fake()->word,
            'serial_number' => fake()->unique()->randomNumber(8),
            'manufacturer' => fake()->company,
            'purchase_date' => fake()->date('Y-m-d'),
            'location' => fake()->address,
            'status' => fake()->randomElement(['Active', 'Inactive', 'Under Repair', 'Pending Disposal']),
            'warranty_period' => fake()->date('Y-m-d', '+1 year'),
            'installation_date' => fake()->date('Y-m-d'),
            'last_service_date' => fake()->date('Y-m-d'),
            'next_service_date' => fake()->date('Y-m-d', '+3 months'),
            'equipment_condition' => fake()->randomElement(['Excellent', 'Good', 'Fair', 'Poor']),
            'equipment_specifications' => fake()->paragraph,
            'usage_duration' => fake()->numberBetween(0, 10000),
            'power_requirements' => fake()->randomNumber(2),
            'network_info' => fake()->ipv4(),
            'software_version' => fake()->randomNumber(3),
            'hardware_version' => fake()->randomNumber(2),
            'purchase_price' => fake()->numberBetween(100, 10000),
            'depreciation_value' => fake()->numberBetween(0, 10000),
            'notes' => fake()->paragraph,
        ];
    }
}
