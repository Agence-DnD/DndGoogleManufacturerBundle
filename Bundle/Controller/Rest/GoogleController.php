<?php

declare(strict_types=1);

namespace Dnd\Google\Manufacturer\Bundle\Controller\Rest;

use Akeneo\UserManagement\Bundle\Context\UserContext;
use Dnd\Google\Manufacturer\Component\Model\GoogleImportExport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class GoogleController
 *
 * @package   Dnd\Google\Manufacturer\Bundle\Controller\Rest
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class GoogleController extends AbstractController
{
    /**
     * Description $translator field
     *
     * @var TranslatorInterface $translator
     */
    private $translator;
    /**
     * Description $userContext field
     *
     * @var UserContext $userContext
     */
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
    public function getAcceptances(): JsonResponse
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
