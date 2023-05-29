<?php

declare(strict_types=1);

namespace Symblaze\Bundle\Http\Tests\Request;

use Symblaze\Bundle\Http\Request\Request;
use Symblaze\Bundle\Http\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestTest extends TestCase
{
    /** @test */
    public function path(): void
    {
        $request = new SymfonyRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->path();

        $this->assertEquals($request->getPathInfo(), $actual);
    }

    /** @test */
    public function method(): void
    {
        $request = new SymfonyRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->method();

        $this->assertEquals($request->getMethod(), $actual);
    }

    /** @test */
    public function uri(): void
    {
        $request = new SymfonyRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->uri();

        $this->assertEquals($request->getUri(), $actual);
    }

    /** @test */
    public function header(): void
    {
        $request = new SymfonyRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->header('Content-Type');

        $this->assertEquals($request->headers->get('Content-Type'), $actual);
    }

    /** @test */
    public function header_default_value(): void
    {
        $request = new SymfonyRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->header('Content-Type', 'application/json');

        $this->assertEquals('application/json', $actual);
    }

    /** @test */
    public function headers(): void
    {
        $request = new SymfonyRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->headers();

        $this->assertSame($request->headers, $actual);
    }

    /** @test */
    public function all(): void
    {
        $request = new SymfonyRequest();
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->all();

        $this->assertSame($request->request->all(), $actual);
    }

    /** @test */
    public function input(): void
    {
        $request = new SymfonyRequest();
        $request->request->set('name', 'John Doe');
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->input('name');

        $this->assertEquals('John Doe', $actual);
    }

    /** @test */
    public function cookie(): void
    {
        $request = new SymfonyRequest();
        $request->cookies->set('name', 'John Doe');
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->cookie('name');

        $this->assertEquals('John Doe', $actual);
    }

    /** @test */
    public function file(): void
    {
        $uploadedFile = new UploadedFile(__FILE__, 'test.php', 'text/plain', null, true);
        $request = new SymfonyRequest();
        $request->files->set('file', $uploadedFile);
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $actual = $sut->file('file');

        $this->assertSame($uploadedFile, $actual);
    }

    /** @test */
    public function has(): void
    {
        $request = new SymfonyRequest();
        $request->request->set('name', 'John Doe');
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $this->assertTrue($sut->has('name'));
        $this->assertFalse($sut->has('email'));
    }

    /** @test */
    public function has_input(): void
    {
        $request = new SymfonyRequest();
        $request->request->set('name', 'John Doe');
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $this->assertTrue($sut->hasInput('name'));
        $this->assertFalse($sut->hasInput('email'));
    }

    /** @test */
    public function has_query(): void
    {
        $request = new SymfonyRequest();
        $request->query->set('name', 'John Doe');
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $this->assertTrue($sut->hasQuery('name'));
        $this->assertFalse($sut->hasQuery('email'));
    }

    /** @test */
    public function has_cookie(): void
    {
        $request = new SymfonyRequest();
        $request->cookies->set('name', 'John Doe');
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $this->assertTrue($sut->hasCookie('name'));
        $this->assertFalse($sut->hasCookie('email'));
    }

    /** @test */
    public function has_file(): void
    {
        $uploadedFile = new UploadedFile(__FILE__, 'test.php', 'text/plain', null, true);
        $request = new SymfonyRequest();
        $request->files->set('file', $uploadedFile);
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $this->assertTrue($sut->hasFile('file'));
        $this->assertFalse($sut->hasFile('email'));
    }

    /** @test */
    public function has_header(): void
    {
        $request = new SymfonyRequest();
        $request->headers->set('Content-Type', 'application/json');
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $sut = new Request($requestStack);

        $this->assertTrue($sut->hasHeader('Content-Type'));
        $this->assertFalse($sut->hasHeader('Accept'));
    }
}
