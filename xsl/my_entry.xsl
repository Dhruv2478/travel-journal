<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
        <head>
            <title>My Journal Entries</title>
            <link rel="stylesheet" type="text/css" href="../css/journal.css"/>
        </head>
        <body>
            <section class="journal-content">
            <div class="container">
                <h2>My Journal Entries</h2>
                <xsl:choose>
                    <xsl:when test="entries/entry">
                        <div class="entries-grid">
                            <xsl:for-each select="entries/entry">
                                <xsl:sort select="date" data-type="text" order="descending"/>
                                <div class="entry-card">
                                    <h3><xsl:value-of select="title"/></h3>
                                    <p><xsl:value-of select="date"/></p>
                                    <p><xsl:value-of select="location"/></p>
                                    <p><xsl:value-of select="content"/></p>
                                    <img src="{image}" alt="{title}" width="300" height="200"/>
                                </div>
                            </xsl:for-each>
                        </div>
                    </xsl:when>
                    <xsl:otherwise>
                        <p>No entries found. Start writing your first adventure!</p>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
            </section>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>