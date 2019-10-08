<?php

class DownloadPDFController extends BaseController {

  protected $download;

  protected $service;

  protected $selects;

  public function __construct(DownloadPDF $download, DownloadPDFService $service) {

    parent::__construct($service);

    $this->download   = $download;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

  public function index() {

  }

  public function create() {

  }

  public function store() {

  }

  public function show($id) {

  }

  public function edit($id) {

  }

  public function update($id) {

  }

  public function destroy($id) {

  }

  public function restore($id) {

  }

  public function report() {

  }

  public function export($type) {

  }

  public function printOne($id) {

  }

  public function printAll() {

  }

}
