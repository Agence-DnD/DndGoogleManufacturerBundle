<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest;

use Dnd\Bundle\GoogleManufacturerBundle\Model\GoogleImportExport;
use Pim\Bundle\UserBundle\Context\UserContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class GoogleController
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2019 Agence Dn'D
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class GoogleController extends AbstractController
{
    /** @var TranslatorInterface $translator */
    private $translator;
    /** @var UserContext $userContext */
    private $userContext;

    /**
     * GoogleController constructor
     *
     * @param TranslatorInterface $translator
     * @param UserContext         $userContext
     *
     * @return void
     */
    public function __construct(
        TranslatorInterface $translator,
        UserContext $userContext
    ) {
        $this->translator  = $translator;
        $this->userContext = $userContext;
    }

    /**
     * Get all acceptances information
     *
     * @return JsonResponse
     */
    public function getAcceptances()
    {
        /** @var string $uiLocale */
        $uiLocale = $this->userContext->getUiLocaleCode() ?? $this->userContext->getCurrentLocale();
        $this->translator->setLocale($uiLocale);

        return new JsonResponse([
            'acceptances' => [
                GoogleImportExport::ACCEPTANCE_LOW    => $this->translator->trans('dnd_google_manufacturer.form.job_instance.tab.googleAcceptance.low'),
                GoogleImportExport::ACCEPTANCE_MEDIUM => $this->translator->trans('dnd_google_manufacturer.form.job_instance.tab.googleAcceptance.medium'),
                GoogleImportExport::ACCEPTANCE_HIGH   => $this->translator->trans('dnd_google_manufacturer.form.job_instance.tab.googleAcceptance.high'),
            ]
        ]);
    }
}
