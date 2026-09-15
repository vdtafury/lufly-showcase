<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\SEO;
use App\Helpers\Security;
use App\Models\Inquiry;

class ContactController extends Controller
{
    public function index(): void
    {
        $prefillSku = Security::sanitizeString((string)($_GET['sku'] ?? ''));
        $prefillProduct = Security::sanitizeString((string)($_GET['product'] ?? ''));

        $breadcrumbs = [
            'Direct Factory Inquiry' => '/contact'
        ];

        $jsonLd = [
            SEO::organizationSchema(),
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $status = $_GET['status'] ?? null;

        $this->render('contact', [
            'pageTitle' => 'Direct Factory Procurement & B2B Inquiry | ' . App::NAME,
            'metaDescription' => 'Contact Lufly manufacturer headquarters in Gaziantep for commercial container export quotes, distributor partnerships, and CAD specs.',
            'canonicalUrl' => App::url('/contact'),
            'prefillSku' => $prefillSku,
            'prefillProduct' => $prefillProduct,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
            'status' => $status,
            'activeNav' => 'contact'
        ]);
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contact');
            return;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!Security::verifyCsrf($csrf)) {
            $this->redirect('/contact?status=csrf_error');
            return;
        }

        $company = Security::sanitizeString((string)($_POST['company_name'] ?? ''));
        $name    = Security::sanitizeString((string)($_POST['contact_name'] ?? ''));
        $email   = Security::sanitizeEmail((string)($_POST['email'] ?? ''));
        $phone   = Security::sanitizeString((string)($_POST['phone'] ?? ''));
        $country = Security::sanitizeString((string)($_POST['country'] ?? ''));
        $sku     = Security::sanitizeString((string)($_POST['product_sku'] ?? ''));
        $type    = Security::sanitizeString((string)($_POST['inquiry_type'] ?? 'quote'));
        $message = Security::sanitizeString((string)($_POST['message'] ?? ''));

        if (!$email || !$name || !$message) {
            $this->redirect('/contact?status=validation_error');
            return;
        }

        $inquiryModel = new Inquiry();
        $inquiryModel->create([
            'company_name' => $company,
            'contact_name' => $name,
            'email'        => $email,
            'phone'        => $phone,
            'country'      => $country,
            'product_sku'  => $sku,
            'product_name' => $sku,
            'inquiry_type' => $type,
            'message'      => $message,
        ]);

        $this->redirect('/contact?status=success');
    }
}
