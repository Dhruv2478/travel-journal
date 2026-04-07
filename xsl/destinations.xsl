<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
        <xsl:for-each select="destinations/destination">
            <div class="post">
                <div class="post-meta">
                    <span class="author">
                        <i class="fa-solid fa-user"></i> <xsl:value-of select="author"/>
                    </span>
                    <span class="date">
                        <i class="fa-solid fa-calendar"></i> <xsl:value-of select="date"/>
                    </span>
                </div>

                <xsl:if test="image != ''">
                    <div class="post-image">
                        <img>
                            <xsl:attribute name="src">
                                <xsl:value-of select="image"/>
                            </xsl:attribute>
                            <xsl:attribute name="alt">
                                <xsl:value-of select="title"/>
                            </xsl:attribute>
                        </img>
                    </div>
                </xsl:if>

                <h2 class="post-title"><xsl:value-of select="title"/></h2>
                <p class="post-excerpt"><xsl:value-of select="excerpt"/></p>

                <div class="post-footer">
                    <span class="rating">★ <xsl:value-of select="rating"/></span>
                    
                    <div class="button-group">
                        <a class="btn-action">
                            <xsl:attribute name="href">
                                post.php?id=<xsl:value-of select="@id"/>
                            </xsl:attribute>
                            Read More
                        </a>
                        
                        <a class="btn-action">
                            <xsl:attribute name="href">
                                ../html/add_favourite.html?title=<xsl:value-of select="title"/>&amp;location=<xsl:value-of select="category"/>
                            </xsl:attribute>
                            Add To Favourites
                        </a>
                    </div>
                </div>
            </div>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>