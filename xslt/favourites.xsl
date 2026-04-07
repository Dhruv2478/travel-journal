<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
        <tr>
            <td style="padding: 12px; border: 1px solid #ddd;">
                <strong><xsl:value-of select="favourites/item/title"/></strong>
            </td>
            <td style="padding: 12px; border: 1px solid #ddd;">
                <xsl:value-of select="favourites/item/location"/>
            </td>
            <td style="padding: 12px; border: 1px solid #ddd;">
                <xsl:value-of select="favourites/item/description"/>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>