<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:template match="/">
        <xsl:if test="//response/result/doc">
            <table class="mdResultRice">
                <xsl:apply-templates select="//response/result/doc"/>
            </table>
        </xsl:if>
    <xsl:if test="not(//response/result/doc)">
		<h1>Non risultano oggetti da visualizzare</h1>
        </xsl:if>
    </xsl:template>
    <xsl:template match="//response/result/doc">
        <tr>
            <xsl:if test="position() mod 2 = 0">
                <xsl:attribute name="class">pari</xsl:attribute>
            </xsl:if>
            <td>
            	tipoOggetto_show: <xsl:copy-of select="arr[@name='tipoOggetto_show']/str"/><br/>
                <a title="breve">
                    <xsl:for-each select="str[@name='id']">
                        <xsl:attribute name="onclick" >
                            showScheda('<xsl:copy-of select="child::text()" />');</xsl:attribute>
                    </xsl:for-each>
                
                <xsl:if test="arr[@name='tipoOggetto_show']/str='contenitore'">
                    <xsl:if test="arr[@name='originalFileName_show']">
                        Nome file Originale: <b>
                            <xsl:copy-of select="arr[@name='originalFileName_show']/str"/>
                        </b>
                    </xsl:if>  
                    <xsl:if test="arr[@name='mimeType_show']">
                        Tipo File: <b>
                            <xsl:copy-of select="arr[@name='mimeType_show']/str"/>
                        </b>
                    </xsl:if>  
                    <xsl:if test="arr[@name='size_show']">
                        Dimensione: <b>
                            <xsl:copy-of select="arr[@name='size_show']/str"/>
                        </b>
                    </xsl:if>  
                </xsl:if>
                <xsl:if test="arr[@name='tipoOggetto_show']/str='documento'">
                    <xsl:if test="arr[@name='autore_show']">
                        Autore: <b>
                            <xsl:copy-of select="arr[@name='autore_show']/str"/>
                        </b><br/>
                    </xsl:if>  
                    <xsl:if test="arr[@name='titolo_show']">
                        Titolo: <b>
                            <xsl:copy-of select="arr[@name='titolo_show']/str"/>
                        </b><br/>
                    </xsl:if>  
                    <xsl:if test="arr[@name='inventario_show']">
                        Inventario: <b>
                            <xsl:for-each select="arr[@name='inventario_show']/str">
                                <xsl:if test="position()>1">
                                    , 
                                </xsl:if>
                                <xsl:copy-of select="."/>
                            </xsl:for-each>
                        </b><br/>
                    </xsl:if>  
                    <xsl:if test="arr[@name='collocazione_show']">
                        Collocazione: <b>
                            <xsl:for-each select="arr[@name='collocazione_show']/str">
                                <xsl:if test="position()>1">
                                    , 
                                </xsl:if>
                                <xsl:copy-of select="."/>
                            </xsl:for-each>
                        </b>
                    </xsl:if>  
                    
                </xsl:if>
                <xsl:if test="arr[@name='tipoOggetto_show']/str='evento'">
                    <xsl:if test="arr[@name='eventType_show']">
                        Tipo Evento: <b>
                            <xsl:copy-of select="arr[@name='eventType_show']/str"/>
                        </b>
                    </xsl:if>  
                    <xsl:if test="arr[@name='eventDate_show']">
                        <xsl:for-each select="arr[@name='eventDate_show']/str">
                            <xsl:if test="position()=1">
                                Data Inizio Evento: 
                            </xsl:if>
                            <xsl:if test="position()>1">
                                Data Fine Evento: 
                            </xsl:if>
                            <b><xsl:copy-of select="."/></b>
                        </xsl:for-each>
                    </xsl:if>  
                    <xsl:if test="arr[@name='eventOutCome_show']">
                        Esito: <b>
                            <xsl:copy-of select="arr[@name='eventOutCome_show']/str"/>
                        </b>
                    </xsl:if>  
                </xsl:if>
                <xsl:if test="arr[@name='tipoOggetto_show']/str='file'">
                    <xsl:if test="arr[@name='originalFileName_show']">
                        Nome File Originale: <b>
                            <xsl:copy-of select="arr[@name='originalFileName_show']/str"/>
                        </b>
                    </xsl:if>  
                    <xsl:if test="arr[@name='size_show']">
                        Dimensione: <b>
                            <xsl:copy-of select="arr[@name='size_show']/str"/>
                        </b>
                    </xsl:if>  
                    <xsl:if test="arr[@name='mimeType_show']">
                        Tipo File: <b>
                            <xsl:copy-of select="arr[@name='mimeType_show']/str"/>
                        </b>
                    </xsl:if>  
                </xsl:if>
                <xsl:if test="arr[@name='tipoOggetto_show']/str='SchedaF'">
                    <xsl:if test="arr[@name='titolo_show']">
                        <xsl:for-each select="arr[@name='titolo_show']/str">
                            <xsl:if test="position()=1">
                                Titolo: 
                            </xsl:if>
                            <xsl:if test="position()>1">
                                <xsl:text disable-output-escaping="yes">&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;</xsl:text>
                            </xsl:if>
                            <b><xsl:copy-of select="."/></b><br/>
                        </xsl:for-each>
                    </xsl:if>  
                    <xsl:if test="arr[@name='autore_show']">
                        <xsl:for-each select="arr[@name='autore_show']/str">
                            <xsl:if test="position()=1">
                                Autore: 
                            </xsl:if>
                            <xsl:if test="position()>1">
                                <xsl:text disable-output-escaping="yes">&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;</xsl:text>
                            </xsl:if>
                            <b><xsl:copy-of select="."/></b><br/>
                        </xsl:for-each>
                    </xsl:if>  
                </xsl:if>
                <xsl:if test="arr[@name='tipoOggetto_show']/str='SoggettoConservatore'">
                    <xsl:if test="arr[@name='titolo_show']">
                        <xsl:for-each select="arr[@name='titolo_show']/str">
                            <xsl:if test="position()=1">
                                Istituto: 
                            </xsl:if>
                            <xsl:if test="position()>1">
                                <xsl:text disable-output-escaping="yes">&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;</xsl:text>
                            </xsl:if>
                            <b><xsl:copy-of select="."/></b><br/>
                        </xsl:for-each>
                    </xsl:if>  
                </xsl:if>
                <xsl:if test="arr[@name='tipoOggetto_show']/str='ComplessoArchivistico'">
                    <xsl:if test="arr[@name='titolo_show']">
                        <xsl:for-each select="arr[@name='titolo_show']/str">
                            <xsl:if test="position()=1">
                                Complesso Archivistico: 
                            </xsl:if>
                            <xsl:if test="position()>1">
                                <xsl:text disable-output-escaping="yes">&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;</xsl:text>
                            </xsl:if>
                            <b><xsl:copy-of select="."/></b><br/>
                        </xsl:for-each>
                    </xsl:if>  
                </xsl:if>
                <xsl:if test="arr[@name='tipoOggetto_show']/str!='contenitore' and
                    arr[@name='tipoOggetto_show']/str!='documento' and
                    arr[@name='tipoOggetto_show']/str!='evento' and
                    arr[@name='tipoOggetto_show']/str!='file' and
                    arr[@name='tipoOggetto_show']/str!='SchedaF' and
                    arr[@name='tipoOggetto_show']/str!='SoggettoConservatore' and
                    arr[@name='tipoOggetto_show']/str!='ComplessoArchivistico'">
                    ALTRO
                    <xsl:if test="arr[@name='tipoOggetto_show']">
                        Tipo Oggetto: <b>
                            <xsl:copy-of select="arr[@name='tipoOggetto_show']/str"/>
                        </b>
                    </xsl:if>  
                    <xsl:if test="arr[@name='originalFileName_show']">
                        Nome file Originale: <b>
                            <xsl:copy-of select="arr[@name='originalFileName_show']/str"/>
                        </b>
                    </xsl:if>  
                </xsl:if>
                </a>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>