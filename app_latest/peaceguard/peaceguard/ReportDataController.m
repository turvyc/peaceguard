//
//  ReportDataController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import "ReportDataController.h"
#import "Report.h"

@interface ReportDataController ()

@end

@implementation ReportDataController

- (void) makeReportWithType:(NSString *)type severity:(NSString *)severity location:(NSString *)location time:(NSInteger *)time andDescription:(NSString *)description{
    self.theReport = [[Report alloc] initWithType:type severity:severity location:location time:time andDescription:description];
    
}

- (NSString  *) getPOSTData: (NSString *) email{
    
    NSString *postData = [NSString stringWithFormat:@"email=%@&type=%@&severity=%@&location=%@&time=%ld&description=%@&agent=iphone", email, self.theReport.type, self.theReport.severity,self.theReport.location,(long)self.theReport.time,self.theReport.description];
    return postData;
}

//- (NSData *) getJSON: (NSString *) email{
//    //Create the report dictionary
//    NSArray *subKeys = [NSArray arrayWithObjects:@"type", @"severity", @"location", @"time", @"desc", nil];
//    NSArray *subObjects = [NSArray arrayWithObjects:self.theReport.type, self.theReport.severity, self.theReport.location, self.theReport.time, self.theReport.description, nil];
//    //Create the JSON dictionary
//    NSArray *keys = [NSArray arrayWithObjects:@"email", @"report", nil];
//    NSArray *objects = [NSArray arrayWithObjects:@"type", @"severity", nil];
//
//    NSDictionary *report = [NSDictionary dictionaryWithObjects:subObjects forKeys:subKeys];
//    NSDictionary *dicToSerialize = [NSDictionary dictionaryWithObjects:<#(NSArray *)#> forKeys:<#(NSArray *)#>]
//
//}


@end
