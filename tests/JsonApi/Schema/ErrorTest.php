<?php
declare(strict_types=1);

namespace WoohooLabs\Yin\Tests\JsonApi\Schema;

use PHPUnit\Framework\TestCase;
use WoohooLabs\Yin\JsonApi\Schema\Error;
use WoohooLabs\Yin\JsonApi\Schema\ErrorSource;
use WoohooLabs\Yin\JsonApi\Schema\Link\ErrorLinks;

class ErrorTest extends TestCase
{
    /**
     * @test
     */
    public function getId()
    {
        $error = $this->createError()->setId("123456789");
        $this->assertEquals("123456789", $error->getId());
    }

    public function testGetStatus()
    {
        $error = $this->createError()->setStatus("500");
        $this->assertEquals("500", $error->getStatus());
    }

    /**
     * @test
     */
    public function getCode()
    {
        $error = $this->createError()->setCode("UNKNOWN_ERROR");
        $this->assertEquals("UNKNOWN_ERROR", $error->getCode());
    }

    /**
     * @test
     */
    public function getTitle()
    {
        $error = $this->createError()->setTitle("Unknown error!");
        $this->assertEquals("Unknown error!", $error->getTitle());
    }

    /**
     * @test
     */
    public function getDetail()
    {
        $error = $this->createError()->setDetail("An unknown error has happened and no solution exists.");
        $this->assertEquals("An unknown error has happened and no solution exists.", $error->getDetail());
    }

    /**
     * @test
     */
    public function getSource()
    {
        $source = new ErrorSource("/data/attributes/name", "name");

        $error = $this->createError()->setSource($source);
        $this->assertEquals($source, $error->getSource());
    }

    /**
     * @test
     */
    public function transformWithEmptyFields()
    {
        $id = "123456789";
        $status = "500";
        $code = "UNKNOWN_ERROR";
        $title = "Unknown error!";
        $detail = "An unknown error has happened and no solution exists.";

        $error = $this->createError()
            ->setId($id)
            ->setStatus($status)
            ->setCode($code)
            ->setTitle($title)
            ->setDetail($detail)
        ;

        $this->assertEquals(
            [
                "id" => $id,
                "status" => $status,
                "code" => $code,
                "title" => $title,
                "detail" => $detail,
            ],
            $error->transform()
        );
    }

    /**
     * @test
     */
    public function transform()
    {
        $error = $this->createError()
            ->setId("123456789")
            ->setMeta(["abc" => "def"])
            ->setLinks(new ErrorLinks())
            ->setStatus("500")
            ->setCode("UNKNOWN_ERROR")
            ->setTitle("Unknown error!")
            ->setDetail("An unknown error has happened and no solution exists.")
            ->setSource(new ErrorSource("", ""))
        ;

        $this->assertEquals(
            [
                "id" => "123456789",
                "meta" => ["abc" => "def"],
                "links" => [],
                "status" => "500",
                "code" => "UNKNOWN_ERROR",
                "title" => "Unknown error!",
                "detail" => "An unknown error has happened and no solution exists.",
                "source" => [],
            ],
            $error->transform()
        );
    }

    private function createError(): Error
    {
        return new Error();
    }
}
