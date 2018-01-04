<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:template match="/">
        <center><h1>informazioni sui documenti collegati</h1></center>
        <table id="schedaFigli">
            <xsl:apply-templates select="//response/result/doc"/>
        </table>
    </xsl:template>
    
    <xsl:template match="//response/result/doc">
        <tr>
            <td id="value">
                <a title="bid">
                    <xsl:attribute name="onclick">showScheda('<xsl:copy-of select="str[@name='id']" />');</xsl:attribute>
                    <xsl:if test="arr[@name='titolo_show']">
                        <b>
                            <xsl:copy-of select="arr[@name='titolo_show']"/>  
                        </b>
                    </xsl:if>
                    <xsl:if test="not(arr[@name='titolo_show'])">
                        <xsl:if test="arr[@name='originalFileName_show']">
                            <b>
                                <xsl:copy-of select="arr[@name='originalFileName_show']"/>  
                            </b>
                        </xsl:if>
                        <xsl:if test="not(arr[@name='originalFileName_show'])">
                            <xsl:if test="arr[@name='eventType_show']">
                                Evento: <b><xsl:copy-of select="arr[@name='eventType_show']"/></b>
                                Esito: <b><xsl:copy-of select="arr[@name='eventOutCome_show']"/></b>
                                Periodo: <b><xsl:copy-of select="arr[@name='eventDate_show']"/></b>
                            </xsl:if>
                            <xsl:if test="not(arr[@name='eventType_show'])">
                                [Senza descrizione]  
                            </xsl:if>
                        </xsl:if>
                    </xsl:if>
                </a>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>