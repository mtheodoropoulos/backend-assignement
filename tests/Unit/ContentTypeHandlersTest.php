<?php

use App\Handlers\ContentType\CsvHandler;
use App\Handlers\ContentType\JsonHalHandler;
use App\Handlers\ContentType\XmlHandler;
use App\Models\VesselTrack;
use Tests\TestCase;

class ContentTypeHandlersTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->content = [
            [
                "id" => 2,
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 82,
                "speed" => 154,
                "lon" => "16.21578",
                "lat" => "42.03212",
                "course" => 149,
                "heading" => 150,
                "rot" => "",
                "timestamp" => "2013-07-01 17:39:00",
                "created_at" => "2023-09-20T18:03:19.000000Z",
                "updated_at" => "2023-09-20T18:03:19.000000Z",
                "deleted_at" => null
            ],
            [
                "id" => 4,
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 84,
                "speed" => 156,
                "lon" => "16.80937",
                "lat" => "41.34813",
                "course" => 123,
                "heading" => 124,
                "rot" => "",
                "timestamp" => "2013-07-01 17:42:00",
                "created_at" => "2023-09-20T18:03:19.000000Z",
                "updated_at" => "2023-09-20T18:03:19.000000Z",
                "deleted_at" => null
            ]
        ];
    }

    /** @test */
    public function hal_test()
    {
        $hal = new JsonHalHandler();
        $response = $hal->handle($this->content);

        $this->assertStringContainsString('_embedded', $response);
        $this->assertEquals(1, substr_count($response, '_embedded'));

        $this->assertStringContainsString('resource', $response);
        $this->assertEquals(1, substr_count($response, 'resource'));

        $this->assertStringContainsString('_links', $response);
        $this->assertEquals(3, substr_count($response, '_links'));

        foreach (VesselTrack::$exportable as $key) {
            $this->assertStringContainsString($key, $response);
            $this->assertEquals(2, substr_count($response, $key));
        }

        foreach ($this->content as $content) {
            $this->assertStringContainsString('http:\/\/localhost\/data\/' . $content['mmsi'], $response);
            $this->assertEquals(2, substr_count($response, 'http:\/\/localhost\/data\/' . $content['mmsi']));
        }
    }

    /** @test */
    public function csv_test()
    {
        $row1 = ['row1_1', 'row1_2', 'row1_3', 'row1_4', 'row1_5', 'row1_6', 'row1_7', 'row1_8', 'row1_9', 'row1_10', 'row1_11', 'row1_12', 'row1_13'];
        $row2 = ['row2_1', 'row2_2', 'row2_3', 'row2_4', 'row2_5', 'row2_6', 'row2_7', 'row2_8', 'row2_9', 'row2_10', 'row2_11', 'row2_12', 'row2_13'];

        $testContent = [
            $row1,
            $row2
        ];

        $handler = new CsvHandler();
        $csvData = $handler->handle($testContent);

        $this->assertIsString($csvData);
        $this->assertNotEmpty($csvData);

        $expectedCsv = implode(',', VesselTrack::$exportable) . "\n";
        $expectedCsv .= implode(',', $row1) . "\n";
        $expectedCsv .= implode(',', $row2) . "\n";

        $this->assertEquals($expectedCsv, $csvData);
    }

    /** @test */
    public function xml_test()
    {

        $testContent = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => [
                'inner_key1' => 'inner_value1',
                'inner_key2' => 'inner_value2',
            ],
        ];

        $handler = new XmlHandler();
        $xmlData = $handler->handle($testContent);

        $this->assertIsString($xmlData);

        // Check that $xmlData is well-formed XML
        $this->assertXmlStringEqualsXmlString('<?xml version="1.0" encoding="UTF-8" ?><tracks><key1>value1</key1><key2>value2</key2><key3><inner_key1>inner_value1</inner_key1><inner_key2>inner_value2</inner_key2></key3></tracks>', $xmlData);
    }

}
