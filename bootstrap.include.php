<?php
/*
* 
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
* A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
* OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
* SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
* LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
* DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
* THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
* OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* This software is licensed under the LGPL. For more information, see
* <http://docs.eazymatch.net>.
*
* @filesource      bootstrap.include.php
* @author          Rob van der Burgt, Vincent van den Nieuwenhuizen
* 
*/


$emolDir = dirname(__FILE__).'/src/emolclient';

//base connection 
include( $emolDir.'/connectproxy/rest.php' );

//other methods
//include( $emolDir.'/connectproxy/json.php' );
include( $emolDir.'/connectproxy/php.php' );
//include( $emolDir.'/connectproxy/soap.php' );

//classes
include( $emolDir.'/connectManager.php' );
include( $emolDir.'/connect.php' );
include( $emolDir.'/trunk.php' );


/**
 * set configuration for connecting with eazymatch
 */
emolclient_connectManager::setConfig( include( dirname(__FILE__) . '/config.php' ) );