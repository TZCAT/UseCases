<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"
    xmlns:ir="urn:gs1:ecom:inventory_report:xsd:3" exclude-result-prefixes="xsl">
    <xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <ir:inventoryReport xmlns="urn:gs1:ecom:inventory_report:xsd:3">
            <ir:creationDateTime>XXXXX 2005-02-09T11:00:00.000-05:00</ir:creationDateTime>
            <ir:documentStatusCode>ORIGINAL</ir:documentStatusCode>
            <ir:inventoryReportIdentification>
                <ir:entityIdentification>XXXX IS25001</ir:entityIdentification>
            </ir:inventoryReportIdentification>
            <ir:inventoryReportTypeCode>INVENTORY_STATUS</ir:inventoryReportTypeCode>
            <ir:structureTypeCode>LOCATION_BY_ITEM</ir:structureTypeCode>
            <ir:inventoryReportingParty>
                <ir:gln>MOH/IVD VIMS</ir:gln>
            </ir:inventoryReportingParty>
            <ir:reportingPeriod>
                <ir:beginDate>XXXXXX  2005-02-09</ir:beginDate>
            </ir:reportingPeriod>

            <xsl:for-each select="//inventoryItemLocationInformation">
                <ir:inventoryItemLocationInformation>
                    <ir:inventoryLocation>
                        <ir:gln>INVALID_GLN:<xsl:value-of select="facilityId"/></ir:gln>
                    </ir:inventoryLocation>
                    <ir:transactionalTradeItem>
                        <ir:gtin>INVALID_GTIN:<xsl:value-of select="productCode"/></ir:gtin>
                    </ir:transactionalTradeItem>
                    <ir:inventoryStatusLineItem>
                        <lineItemNumber><xsl:value-of select="position()"/></lineItemNumber>
                        <inventoryStatusQuantitySpecification>
                            <inventoryStatusType>ON_HAND</inventoryStatusType>
                            <quantityOfUnits measurementUnitCode="PCS"><xsl:value-of select="ON_HAND"/></quantityOfUnits>
                        </inventoryStatusQuantitySpecification>
                    </ir:inventoryStatusLineItem>
                </ir:inventoryItemLocationInformation>
            </xsl:for-each>
        </ir:inventoryReport>
    </xsl:template>
</xsl:stylesheet>
