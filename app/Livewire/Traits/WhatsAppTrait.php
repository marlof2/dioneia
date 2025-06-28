<?php

namespace App\Livewire\Traits;

trait WhatsAppTrait
{
    public function openWhatsApp($phone, $message = null)
    {
        // Remove caracteres não numéricos do telefone
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        // Adiciona código do país se não estiver presente
        if (strlen($cleanPhone) === 11 && substr($cleanPhone, 0, 2) === '11') {
            $cleanPhone = '55' . $cleanPhone;
        } elseif (strlen($cleanPhone) === 10) {
            $cleanPhone = '55' . $cleanPhone;
        } elseif (strlen($cleanPhone) === 13 && substr($cleanPhone, 0, 2) === '55') {
            // Já tem código do país
            $cleanPhone = $cleanPhone;
        } elseif (strlen($cleanPhone) === 12 && substr($cleanPhone, 0, 2) === '55') {
            // Já tem código do país
            $cleanPhone = $cleanPhone;
        }

        // Mensagem padrão
        // $message = urlencode($message ?? "Olá! Gostaria de falar sobre seu atendimento.");

        // Cria a URL do WhatsApp com mensagem
        $whatsappUrl = "https://wa.me/{$cleanPhone}?text={$message}";

        // Retorna script JavaScript para abrir em nova aba
        $this->dispatch('open-whatsapp', url: $whatsappUrl);
    }
}
