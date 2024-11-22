<?php

class SunatController{
   

    static public function crearXmlBoleta($params) {
       
        $xmlData = '<?xml version="1.0" encoding="UTF-8"?>
        <Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
           <ext:UBLExtensions>
              <ext:UBLExtension>
                 <ext:ExtensionContent />
              </ext:UBLExtension>
           </ext:UBLExtensions>
           <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
           <cbc:CustomizationID>2.0</cbc:CustomizationID>';
        $xmlData .= '<cbc:ID>' . $params['serie_nrocomprobante'] . '</cbc:ID>
           <cbc:IssueDate>' . $params['fecha'] . '</cbc:IssueDate>
           <cbc:IssueTime>' . $params['hora'] . '</cbc:IssueTime>
           <cbc:InvoiceTypeCode listID="0101">03</cbc:InvoiceTypeCode>
           <cbc:Note languageLocaleID="1000"><![CDATA[SON CIENTO DIECIOCHO CON 00/100 SOLES]]></cbc:Note>
           <cbc:DocumentCurrencyCode>PEN</cbc:DocumentCurrencyCode>
           <cac:Signature>
              <cbc:ID>' . $params['ruc'] . '</cbc:ID>
              <cac:SignatoryParty>
                 <cac:PartyIdentification>
                    <cbc:ID>' . $params['ruc'] . '</cbc:ID>
                 </cac:PartyIdentification>
                 <cac:PartyName>
                    <cbc:Name><![CDATA[' . $params['nombreNegocio'] . ']]></cbc:Name>
                 </cac:PartyName>
              </cac:SignatoryParty>
              <cac:DigitalSignatureAttachment>
                 <cac:ExternalReference>
                    <cbc:URI>#GREENTER-SIGN</cbc:URI>
                 </cac:ExternalReference>
              </cac:DigitalSignatureAttachment>
           </cac:Signature>
           <cac:AccountingSupplierParty>
              <cac:Party>
                 <cac:PartyIdentification>
                    <cbc:ID schemeID="6">20123456789</cbc:ID>
                 </cac:PartyIdentification>
                 <cac:PartyName>
                    <cbc:Name><![CDATA[GREENTER]]></cbc:Name>
                 </cac:PartyName>
                 <cac:PartyLegalEntity>
                    <cbc:RegistrationName><![CDATA[GREENTER S.A.C.]]></cbc:RegistrationName>
                    <cac:RegistrationAddress>
                       <cbc:ID>150101</cbc:ID>
                       <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                       <cbc:CitySubdivisionName>CASUARINAS</cbc:CitySubdivisionName>
                       <cbc:CityName>LIMA</cbc:CityName>
                       <cbc:CountrySubentity>LIMA</cbc:CountrySubentity>
                       <cbc:District>LIMA</cbc:District>
                       <cac:AddressLine>
                          <cbc:Line><![CDATA[AV NEW DEÁL 123]]></cbc:Line>
                       </cac:AddressLine>
                       <cac:Country>
                          <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                       </cac:Country>
                    </cac:RegistrationAddress>
                 </cac:PartyLegalEntity>
                 <cac:Contact>
                    <cbc:Telephone>01-234455</cbc:Telephone>
                    <cbc:ElectronicMail>admin@greenter.com</cbc:ElectronicMail>
                 </cac:Contact>
              </cac:Party>
           </cac:AccountingSupplierParty>
           <cac:AccountingCustomerParty>
              <cac:Party>
                 <cac:PartyIdentification>
                    <cbc:ID schemeID="1">20203030</cbc:ID>
                 </cac:PartyIdentification>
                 <cac:PartyLegalEntity>
                    <cbc:RegistrationName><![CDATA[PERSON 1]]></cbc:RegistrationName>
                 </cac:PartyLegalEntity>
              </cac:Party>
           </cac:AccountingCustomerParty>
           <cac:TaxTotal>
              <cbc:TaxAmount currencyID="PEN">18.00</cbc:TaxAmount>
              <cac:TaxSubtotal>
                 <cbc:TaxableAmount currencyID="PEN">100.00</cbc:TaxableAmount>
                 <cbc:TaxAmount currencyID="PEN">18.00</cbc:TaxAmount>
                 <cac:TaxCategory>
                    <cac:TaxScheme>
                       <cbc:ID>1000</cbc:ID>
                       <cbc:Name>IGV</cbc:Name>
                       <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                 </cac:TaxCategory>
              </cac:TaxSubtotal>
           </cac:TaxTotal>
           <cac:LegalMonetaryTotal>
              <cbc:LineExtensionAmount currencyID="PEN">100.00</cbc:LineExtensionAmount>
              <cbc:TaxInclusiveAmount currencyID="PEN">118.00</cbc:TaxInclusiveAmount>
              <cbc:PayableAmount currencyID="PEN">118.00</cbc:PayableAmount>
           </cac:LegalMonetaryTotal>
           <cac:InvoiceLine>
              <cbc:ID>1</cbc:ID>
              <cbc:InvoicedQuantity unitCode="NIU">2</cbc:InvoicedQuantity>
              <cbc:LineExtensionAmount currencyID="PEN">100.00</cbc:LineExtensionAmount>
              <cac:PricingReference>
                 <cac:AlternativeConditionPrice>
                    <cbc:PriceAmount currencyID="PEN">59</cbc:PriceAmount>
                    <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                 </cac:AlternativeConditionPrice>
              </cac:PricingReference>
              <cac:TaxTotal>
                 <cbc:TaxAmount currencyID="PEN">18.00</cbc:TaxAmount>
                 <cac:TaxSubtotal>
                    <cbc:TaxableAmount currencyID="PEN">100.00</cbc:TaxableAmount>
                    <cbc:TaxAmount currencyID="PEN">18.00</cbc:TaxAmount>
                    <cac:TaxCategory>
                       <cbc:Percent>18</cbc:Percent>
                       <cbc:TaxExemptionReasonCode>10</cbc:TaxExemptionReasonCode>
                       <cac:TaxScheme>
                          <cbc:ID>1000</cbc:ID>
                          <cbc:Name>IGV</cbc:Name>
                          <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                       </cac:TaxScheme>
                    </cac:TaxCategory>
                 </cac:TaxSubtotal>
              </cac:TaxTotal>
              <cac:Item>
                 <cbc:Description><![CDATA[PROD 1]]></cbc:Description>
                 <cac:SellersItemIdentification>
                    <cbc:ID>C023</cbc:ID>
                 </cac:SellersItemIdentification>
              </cac:Item>
              <cac:Price>
                 <cbc:PriceAmount currencyID="PEN">50</cbc:PriceAmount>
              </cac:Price>
           </cac:InvoiceLine>
        </Invoice>';

        return $xmlData;
    }

    

}