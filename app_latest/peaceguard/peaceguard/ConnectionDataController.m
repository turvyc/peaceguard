//
//  ConnectionDataController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-02.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "ConnectionDataController.h"

@implementation ConnectionDataController


- (BOOL) serverLoginWithEmail:(NSString *)email andPassword:(NSString *)password{
    
    NSString *post = [NSString stringWithFormat:@"email=%@&password=%@&agent=iphone", email, password];
    NSLog(@"Data: %@",post);
    
    NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
    
    NSString *postLength = [NSString stringWithFormat:@"%d", [postData length]];
    
    NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
    
    [request setURL:[NSURL URLWithString:@"http://peaceguard.dyndns.org:1728/control/login.control.php"]];
    [request setHTTPMethod:@"POST"];
    [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPBody:postData];
    NSLog(@"Data: %@",request);
    //End of POST
    
    //Receive JSON
    NSURLResponse *response;
    NSError *err;
    NSData *responseData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&err];
    NSLog(@"Data: %@",responseData);
    NSString *responseString = [[NSString alloc] initWithData:responseData encoding:NSASCIIStringEncoding];
    NSLog(@"Data: %@", responseString);
    
    //JSON processing
    NSError *error;
    NSDictionary *jsonDictionary = [NSJSONSerialization JSONObjectWithData:responseData options:NSJSONReadingMutableContainers error:&error];
    if (! error) {
        NSLog(@"%@",jsonDictionary);
    }else{
        NSLog(@"%@",error.localizedDescription);
    }
    
    NSLog(@"JSON: %@", jsonDictionary);
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    if(success){
        NSLog(@"Successful!!!");
    }
    else{
        success = NO;
    }
    
    return success;
}

- (void) reportWithPostData: (NSString *) data{
    
    NSString *post = data;
    NSLog(@"Data: %@",post);
    
    NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
    
    NSString *postLength = [NSString stringWithFormat:@"%d", [postData length]];
    
    NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
    
    [request setURL:[NSURL URLWithString:@"http://peaceguard.dyndns.org:1728/control/report.control.php"]];
    [request setHTTPMethod:@"POST"];
    [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPBody:postData];
    NSLog(@"Data: %@",request);
    //End of POST
    
    //Receive JSON
    NSURLResponse *response;
    NSError *err;
    NSData *responseData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&err];
    NSLog(@"Data: %@",responseData);
    NSString *responseString = [[NSString alloc] initWithData:responseData encoding:NSASCIIStringEncoding];
    NSLog(@"Data: %@", responseString);
    
    //JSON processing
    NSError *error;
    NSDictionary *jsonDictionary = [NSJSONSerialization JSONObjectWithData:responseData options:NSJSONReadingMutableContainers error:&error];
    if (! error) {
        NSLog(@"%@",jsonDictionary);
    }else{
        NSLog(@"%@",error.localizedDescription);
    }
    
    NSLog(@"JSON: %@", jsonDictionary);
    
    BOOL success = [[jsonDictionary objectForKey:@"successful"] boolValue];
    
    NSString *test = @"done";
    if(success){
        NSLog(@"Successful!!!");
        test = @"Succesful";
    }
    else{
        success = NO;
        test = @"failed";
    }


}

@end
